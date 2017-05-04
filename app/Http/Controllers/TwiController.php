<?php

/*
|--------------------------------------------------------------------------
| Application Tweet Controller   //////////////////////////////////////////
| Control class twi.blade.php    //////////////////////////////////////////
| Author Ruben Faraj 2017 , Email: Reben_f@hotmail.co.uk //////////////////
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Twitter;
use App\Tweets;

class TwiController extends Controller
{
	public function __construct()
    {
        $tweets = Twitter::getUserTimeline(['screen_name' => 'reben988', 'count' => 1]);
    	foreach ($tweets as $tweet) {
    		$tw	=	$tweet->id;
    		$text = $tweet->text;
            $media = $tweet->entities->media[0]->media_url;
            $retweet = $tweet->retweet_count;
            $fav = $tweet->favorite_count;
            
    	}
         // query 
        $check = Tweets::orderBy('created_at','DESC')
                            ->where('twitid',$tw)
                            ->first();


        if (is_null($check)) {
            //saving the media
            if (!is_null($media)) {
                $extension = pathinfo($media, PATHINFO_EXTENSION);
                $filename = str_random(4) . "-" . str_slug($tw).".".$extension;// replacing image name
                $file = file_get_contents($media);// saving the image in public/image file
                $save = file_put_contents('images/'.$filename,$file);// saving the tweet image_url
            }
                
    		// Tweet Variables 
            $Tweets = new Tweets;
            $Tweets -> twitid = $tw;
            $Tweets -> images_url = $filename;
            $Tweets -> favorite = $fav;
            $Tweets -> retweet = $retweet;
            $Tweets -> text = $text;
            $Tweets -> save();// save all the variables in the database

    	}


    }
    // function index return or Display twi.blade.php content 
    public function index(){
    	$tweets = Tweets::all();
    	return view('twi')->with('tweets', $tweets);
    }
}
