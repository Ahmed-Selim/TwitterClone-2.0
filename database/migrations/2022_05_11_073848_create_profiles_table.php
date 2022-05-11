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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id('id');
            
            $table->string('name');
            $table->string('username')->unique();
            $table->date('birth_date') ;
            $table->string('location')->nullable() ;
            $table->string('bio')->nullable() ;
            $table->string('gender') ;
            $table->string('profile_image')->nullable() ;
            $table->string('cover_image')->nullable() ;
            $table->string('website')->nullable() ;
            
            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users','id')->onDelete('cascade') ;
            $table->timestamps();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
