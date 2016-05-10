<?php namespace Gooeypress\Workers;

use Exception;
use Illuminate\Queue\Jobs\Job;
use Intervention\Image\ImageManager;
use Log, Theme, Config, DB, Event;

/**
 * Generate screenshot for themes using `phantomjs`
 */
class ScreenshotWorker {

    /**
     * @var ImageManager
     */
    protected $imageManager;

    /**
     * @param ImageManager $imageManager
     */
    public function __construct(ImageManager $imageManager)
    {

        $this->imageManager = $imageManager;
    }

    /**
     * Take a screenshot
     *
     * @param Job $job
     * @param $data : ['theme_id' => $theme_id]
     * @throws Exception
     */
    public function fire(Job $job, $data)
    {
        $theme_id = $data['theme_id'];

        $theme = Theme::findOrFail($theme_id);

        if ($theme->default_layout_id <= 1)
        {
            $job->release();
        }

        $layout = DB::select('SELECT * FROM layout_theme WHERE theme_id = ? AND layout_id = ?',
            [$theme->id, $theme->default_layout_id]);

        if (empty($layout))
        {
            throw new Exception("No layout [$theme->default_layout_id] found for theme [{$theme->id}]");
        }
        $layout = $layout[0];

        $filename = md5($layout->url . '*()_Iop{');

        $cmd = join(' ', [Config::get('workers.phantomjs_path'),
            Config::get('workers.screenshot_script_path'),
            $layout->url,
            "/tmp/$filename"
        ]);

        Log::info("Creating screenshot for {$layout->url}" . PHP_EOL);
        Log::info($cmd . PHP_EOL);
        exec($cmd, $output, $return);
        Log::info("Screenshot created for {$layout->url} at /tmp/$filename" . PHP_EOL);

        $local_image_url = $this->save("/tmp/$filename.png");

        Log::info("Updating screenshot for $layout->url to $local_image_url" . PHP_EOL);
        DB::update('UPDATE layout_theme SET screenshot = ?
            WHERE url = ?',
            array($local_image_url, $layout->url));

        $theme_ids = DB::select('SELECT theme_id FROM layout_theme WHERE url = ?', array($layout->url));
        $ids = array();
        if (is_array($theme_ids) && count($theme_ids) > 0)
        {
            foreach ($theme_ids as $tid)
            {
                $ids[] = intval($tid->theme_id);
            }
            $ids = join(',', $ids);
            DB::update("UPDATE themes SET screenshot = ?
                WHERE id IN ($ids)", array($local_image_url));
        }

        Event::fire('workers.ScreenshotWasTaken', [$ids]);

        $job->delete();
    }

    /**
     * @param string $tmp_path
     * @return string
     */
    private function save($tmp_path)
    {
        $base = basename($tmp_path);
        $filename = substr($base, 3);
        $subfolder = substr($base, 0, 3);

        list($name, $suffix) = explode('.', $filename);

        $filepath = join('/', array(storage_path(), 'shots', $subfolder, $filename));
        $dirpath = dirname($filepath) . "/";
        if (!file_exists($dirpath))
        {
            mkdir($dirpath, 0755, true);
        }

        $this->imageManager->make($tmp_path)
            ->save($dirpath . $filename)
            ->resize(800, 600)
            ->save($dirpath . "$name-800x600.$suffix")
            ->resize(400, 300)
            ->save($dirpath . "$name-400x300.$suffix");

        return join('/', array($subfolder, $name));
    }
}
