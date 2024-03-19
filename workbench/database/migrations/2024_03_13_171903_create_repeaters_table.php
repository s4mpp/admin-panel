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
        Schema::create('repeaters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('child_repeaters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('main_repeater_id')->references('id')->on('repeaters');
            $table->timestamps();
        });

        Schema::create('other_child_repeaters', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('main_repeater_id')->references('id')->on('repeaters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_child_repeaters');
        Schema::dropIfExists('child_repeaters');
        Schema::dropIfExists('repeaters');
    }
};
