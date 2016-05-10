<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FakePhantomCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fake:phantom';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '模拟PhantomJS, 以便加速开发流程';

	/**
	 * @var \Intervention\Image\ImageManager
	 */
	protected $imageManager;

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct(\Intervention\Image\ImageManager $imageManager)
	{
		parent::__construct();
		$this->imageManager = $imageManager;
	}

	/**
	 * Execute the console command.
	 *
	 */
	public function fire()
	{
		$action = $this->argument('action');

		switch($action){
			case 'screenshot':
				return $this->fakeScreenshot();
			case 'yslow':
				return $this->fakeYslow();
		}
	}

	protected function fakeScreenshot()
	{
		$image_path = $this->argument('image_path');

		$this->imageManager->make(app_path('storage/placeholder.png'))
			->save($image_path . ".png");
	}

	protected function fakeYslow()
	{
		$json = File::get(app_path('storage/yslow.json'));

		echo $json;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('action', InputArgument::REQUIRED, 'screenshot | yslow'),
			array('url', InputArgument::REQUIRED, 'URL to fetch'),
			array('image_path', InputArgument::OPTIONAL, 'Screenshot path'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('info', null, InputOption::VALUE_OPTIONAL, 'YSlow --info option', null),
			array('format', null, InputOption::VALUE_OPTIONAL, 'YSlow --format option', null),
		);
	}

}
