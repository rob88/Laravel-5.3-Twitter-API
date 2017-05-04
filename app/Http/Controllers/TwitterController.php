<?php
/*
|--------------------------------------------------------------------------
| Application Twitter Controller Class ////////////////////////////////////
| Control twiter.blade.php             ////////////////////////////////////
| Class Role display or post tweet to your personal twitter account ///////
| Author Ruben Faraj 2017 , Email: Reben_f@hotmail.co.uk //////////////////
|--------------------------------------------------------------------------
*/
namespace App\Http\Controllers;
use Twitter;
use File;
use Illuminate\Http\Request;

class TwitterController extends Controller
{
    /**
     * Create a new controller instance for tweets .
     * display 100 tweets 
     * @return void
     */
    public function mytwittes()
    {
        $data = Twitter::getUserTimeline(['count' => 100, 'format' => 'array']);
        return view('twitter',compact('data'));
    }

    /**
     * Create a new controller instance for Tweets.
     *
     * @return void
     */
    public function tweet(Request $request)
    {
        $this->validate($request, [
                'tweet' => 'required'
            ]);

        $newTwitte = ['status' => $request->tweet];

        
        if(!empty($request->images)){
            foreach ($request->images as $key => $value) {
                $uploaded_media = Twitter::uploadMedia(['media' => File::get($value->getRealPath())]);
                if(!empty($uploaded_media)){
                    $newTwitte['media_ids'][$uploaded_media->media_id_string] = $uploaded_media->media_id_string;
                }
            }
        }

        $twitter = Twitter::postTweet($newTwitte);
       
        return back();
    }
}