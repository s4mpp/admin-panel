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
        Schema::create('numbers', function (Blueprint $table): void {
            $table->id();

            $table->string('title');

            $table->decimal('basic_decimal');
            $table->decimal('basic_decimal_2');
            $table->decimal('basic_decimal_min');
            $table->decimal('basic_decimal_max');
            
            $table->integer('basic_integer');
            $table->integer('basic_integer_2');
            $table->integer('basic_integer_min');
            $table->integer('basic_integer_max');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('numbers');
    }
};
