<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RatingsSyncCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ratings:sync';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Syncronize the rating counts and averages of themes in the database.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $reviews = DB::select('SELECT
                theme_id,
                COUNT(user_id) AS rating_count,
                AVG(rating) AS rating
            FROM reviews GROUP BY theme_id');


        foreach($reviews as $review){
            if($review->rating_count > 0){
                DB::update('UPDATE themes SET rating = ?, rating_count = ? WHERE id = ?',
                    array($review->rating, $review->rating_count, $review->theme_id));

                printf("Updating theme(%d) rating to (%.2f/%d)\n", 
                    $review->theme_id, $review->rating, $review->rating_count);
            }
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
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
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
