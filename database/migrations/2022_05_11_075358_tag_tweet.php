<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_tweet', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('tag_id');
            // $table->unsignedBigInteger('tweet_id');
            // $table->foreign('tag_id')->references('id')->on('tweet_tags')->onDelete('cascade') ;
            // $table->foreign('tweet_id')->references('id')->on('tweets')->onDelete('cascade') ;
            $table->foreignId('tag_id')->constrained('tweet_tags','id')->onDelete('cascade') ;
            $table->foreignId('tweet_id')->constrained('tweets','id')->onDelete('cascade') ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tag_tweet');
    }
};
