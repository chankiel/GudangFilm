<?php

use App\Models\Film;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('director');
            $table->year('release_year');
            $table->bigInteger('price');
            $table->integer('duration');
            $table->string('video_url')->nullable();
            $table->string('cover_image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('film_genres',function(Blueprint $table){
            $table->unsignedBigInteger('film_id');
            $table->enum('genre',Film::genreList());
            $table->primary(['film_id','genre']);
            $table->foreign('film_id')->references('id')->on('films')
            ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
        Schema::dropIfExists('film_genres');
    }
};
