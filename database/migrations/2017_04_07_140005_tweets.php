<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tweets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // creating table tweets when php artisan migrate run
        Schema::create('tweets', function (Blueprint $table) {
            $table -> increments('id'); // id 
            $table -> string('twitid')->unique(); //unique twitid 
            $table -> string('images_url'); // store image url
            $table -> string('favorite');// favorite tweet
            $table -> string('retweet')->nullable(); // retweet
            $table -> longtext('text'); // tweet post coontent 
            $table->timestamps(); // timestamp of time the tweet stored
        });
    }

    /**
     * Reverse the migrations.
     * drop table tweet
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('tweets');
    }
}
