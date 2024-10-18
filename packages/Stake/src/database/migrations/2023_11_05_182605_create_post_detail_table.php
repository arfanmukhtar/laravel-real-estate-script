<?php

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
        Schema::create('post_details', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id');
            $table->tinyInteger('bedrooms')->nullable();
            $table->tinyInteger('bathrooms')->nullable();
            $table->integer('build_year')->nullable();
            $table->string('lat' , 20)->nullable();
            $table->string('lng', 20)->nullable();
            $table->text('nearest_places')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_details');
    }
};
