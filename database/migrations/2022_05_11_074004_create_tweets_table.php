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
        Schema::create('tweets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('profiles','id')->onDelete('cascade');

            $table->text('body') ;
            // $table->string('media_url') ;
            $table->unsignedBigInteger('likes')->default(0);
            $table->unsignedBigInteger('retweets')->default(0);
            $table->unsignedBigInteger('replies')->default(0);

            $table->timestamps();
            $table->index('profile_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tweets');
    }
};
