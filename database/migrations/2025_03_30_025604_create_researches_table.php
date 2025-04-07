<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('researches', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('course');
            $table->text('researchers');
            $table->string('adviser');
            $table->year('year');
            $table->text('abstract');
            $table->text('keywords');
            $table->string('program')->nullable(); // BSN, etc.
            $table->string('category')->nullable(); // BED, SHS, ABM, STEM, HUMMS
            $table->string('research_design')->nullable(); // Qualitative, Quantitative, etc.
            $table->string('research_type')->nullable(); // Phenomenology, Case Study, etc.
            $table->integer('respondents_count')->nullable();
            $table->string('file_path')->nullable(); // For uploaded files
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('researches');
    }
};
