<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('multiples', function (Blueprint $table): void {
            $table->id();

            $table->string('title');

            $table->string('array');
            $table->string('array_multidimensional');
            $table->string('array_multidimensional_with_key');
            $table->string('array_multidimensional_with_value_as_key');
            $table->string('array_with_callback');
            $table->string('enum');
            $table->string('enum_with_callback');
            $table->string('collection');
            $table->string('collection_multidimensional');
            $table->string('collection_multidimensional_with_key');
            $table->string('collection_multidimensional_with_value_as_key');
            $table->string('eloquent_collection');
            $table->string('eloquent_collection_with_key');
            $table->string('eloquent_collection_with_value_as_key');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multiples');
    }
};
