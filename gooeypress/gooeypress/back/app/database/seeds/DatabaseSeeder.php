<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('InitSeeder');
//		$this->call('CreativeMarketSeeder');
//		$this->call('CreativeSeeder');
//		$this->call('ElegantThemesSeeder');
		$this->call('ElegantSeeder');
//		$this->call('ForestSeeder');
//		$this->call('MojoThemesSeeder');
//		$this->call('MonsterSeeder');
//		$this->call('PremiumPressSeeder');
		$this->call('PremiumPressSeeder2');
//		$this->call('TemplateMonsterSeeder');
		$this->call('TemplaticSeeder');
//		$this->call('ThemeForestSeeder');
//		$this->call('WordpressSeeder');
//		$this->call('WPMUDevSeeder');
		$this->call('ExtraSeeder');
    }
}

class InitSeeder extends Seeder
{
    public function run()
    {
        DB::statement('TRUNCATE TABLE layout_theme');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Theme::truncate();
        Vendor::truncate();
        Author::truncate();
        Requirement::truncate();
        Layout::truncate();
        Style::truncate();
        Genre::truncate();
        Licence::truncate();
        Platform::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        Requirement::create([ 'name' => 'No requirements' ]);
        Layout::create([ 'name' => 'Single Column']);

        Style::create([ 'name' => 'Flat' ]);
        Genre::create([ 'name' => 'Blog' ]);

        Licence::create([ 'name' => 'GPL v2.0' ]);

        Platform::create([ 'name' => 'WordPress' ]);

        User::create([ 'username' => 'admin',
            'email' => 'dzy0451@gmail.com',
            'nicename' => 'Admin',
            'role' => 'admin',
            'password' => Hash::make('admin')]);

        User::create([ 'username' => 'zhiyan',
            'email' => 'dzy0451@163.com',
            'nicename' => 'Zhiyan',
            'role' => 'user',
            'password' => Hash::make('zhiyan')]);
    }
}
class ExtraSeeder extends Seeder
{
    public function run()
    {
        Review::create(['user_id' => 1, 'theme_id' => 1, 'comment' => 'Test rating: 3', 'rating' => 3]);
        Review::create(['user_id' => 2, 'theme_id' => 1, 'comment' => 'Test rating: 2', 'rating' => 2]);

        Like::create(['user_id' => 2, 'theme_id' => 1]);

        $theme = Theme::find(1);
        $theme->likes_count = 1;
        $theme->rating = 2.5;
        $theme->rating_count = 2;
        $theme->licence_id = 1;
        $theme->platform_id = 1;
        $theme->genre_id = 1;
        $theme->style_id = 1;
        $theme->save();
    }
}

abstract class ProductionSeeder extends Seeder
{
    protected $filename = '/data.csv';
    protected $vendor = '';

    abstract protected function getThemeFromLine($line);

    public function run()
    {
        $vendor = null;
        if($this->vendor != ''){
            $vendor = Vendor::firstOrCreate(['name' => $this->vendor]);
        }

        $csv = fopen(dirname(__FILE__) .'/'. $this->filename, 'r');

        fgets($csv);

        while(!feof($csv)){

            list($theme, $author) = $this->getThemeFromLine(fgetcsv($csv));

            if(!$theme) break;

            $thor = Author::where('name', '=', $author)->take(1)->get()->toArray();
            if(is_array($thor) && count($thor) == 0){
                $thor = Author::create(['name' => $author]);
                $thor = $thor->toArray();
            }else{
                $thor = $thor[0];
            }
            $theme['author_id'] = $thor['id'];
            if($vendor != null){
                $theme['vendor_id'] = $vendor['id'];
            }

            $theme['hash'] = uniqid();

            Theme::create($theme);
        }
        fclose($csv);
    }
}
abstract class ProductionVendorSeeder extends Seeder
{
    protected $filename = '/data.csv';
    protected $vendor = 'vendor name';

    protected function getThemeFromLine($line){
        list($url, $demo, $price, $name)
            = $line;

        if(trim($name) == '') return false;

        $theme = [
            'link_purchase' => $url,
            'link_demo' => $demo,
            'title' => $name,
            'price' => trim($price, '$'),
            'n_complete' => 5,
        ];

        return $theme;
    }

    public function run()
    {
        $vendor = Vendor::firstOrCreate(['name' => $this->vendor]);

        $csv = fopen(dirname(__FILE__) .'/'. $this->filename, 'r');

        fgets($csv);

        while(!feof($csv)){

            $theme = $this->getThemeFromLine(fgetcsv($csv));

            if(!$theme) break;

            $theme['vendor_id'] = $vendor['id'];
            $theme['hash'] = uniqid();

            Theme::create($theme);
        }
        fclose($csv);
    }
}

class ProductionAuthorSeeder extends ProductionSeeder
{
    protected $filename = 'data.csv';
    protected $vendor = 'vendor name';

    protected function getThemeFromLine($line){
        list($url, $demo, $price, $name, $author)
            = $line;

        if(trim($author) == '') return [false, false];

        $theme = [
            'link_purchase' => $url,
            'link_demo' => $demo,
            'title' => $name,
            'price' => trim($price, '$'),
            'n_complete' => 4,
        ];

        $author = trim($author);

        return [ $theme, $author ];
    }
}

class CreativeMarketSeeder extends ProductionAuthorSeeder
{
    protected $filename = 'creative_market.csv';
    protected $vendor = 'Creative Market';
}

class CreativeSeeder extends ProductionAuthorSeeder
{
    protected $filename = 'creative.csv';
    protected $vendor = 'Creative Market';
}

class ElegantThemesSeeder extends ProductionVendorSeeder
{
    protected $filename = 'elegant_themes_new.csv';
    protected $vendor = 'ElegantThemes';
}

class ElegantSeeder extends ProductionVendorSeeder
{
    protected $filename = 'elegant.csv';
    protected $vendor = 'ElegantThemes';
}

class ForestSeeder extends ProductionAuthorSeeder
{
    protected $filename = 'forest.csv';
    protected $vendor = 'Themeforest';
}

class MojoThemesSeeder extends ProductionAuthorSeeder
{
    protected $filename = 'mojo_themes.csv';
    protected $vendor = 'Mojo Themes';
}

class MonsterSeeder extends ProductionAuthorSeeder
{
    protected $filename = 'monster.csv';
    protected $vendor = 'Templatemonster';
}

class PremiumPressSeeder extends ProductionVendorSeeder
{
    protected $filename = 'premium_press_new.csv';
    protected $vendor = 'PremiumPress';
}

class PremiumPressSeeder2 extends ProductionVendorSeeder
{
    protected $filename = 'premium.csv';
    protected $vendor = 'PremiumPress';
}

class TemplateMonsterSeeder extends ProductionAuthorSeeder
{
    protected $filename = 'template_monster_new.csv';
    protected $vendor = 'Templatemonster';
}

class TemplaticSeeder extends ProductionVendorSeeder
{
    protected $filename = 'templatic.csv';
    protected $vendor = 'Templatic';
}

class ThemeForestSeeder extends ProductionAuthorSeeder
{
    protected $filename = 'theme_forest_full.csv';
    protected $vendor = 'Themeforest';
}

class WordpressSeeder extends ProductionAuthorSeeder
{
    protected $filename = 'wordpress_new.csv';
}

class WPMUDevSeeder extends ProductionVendorSeeder
{
    protected $filename = 'wpmudev.csv';
    protected $vendor = 'WPMUDev';
}
