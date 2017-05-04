<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Twitter;
use App\Tweets;


class UpdateTweets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:tweets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates Tweets to database';

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
    public function handle()
    {
        //
        $tweets = Twitter::getUserTimeline(['screen_name' => 'reben988', 'count' => 1]);
        foreach ($tweets as $tweet) {
            $tw =   $tweet->id;
            $text = $tweet->text;
        }

        $check = Tweets::orderBy('created_at', 'desc')->where('twitid',$tw)->first();

        if (is_null($check)) {
            //echo "input <br>";
            $Tweets = new Tweets;
            $Tweets -> twitid = $tw;
            $Tweets -> text = $text;
            $Tweets -> save();

        }
        else{
            //echo "no input";
        }
    }
}
