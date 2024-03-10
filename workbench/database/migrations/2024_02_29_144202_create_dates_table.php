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
        Schema::create('dates', function (Blueprint $table): void {
            $table->id();

            $table->string('title');

            $table->date('basic_date')->nullable();
            $table->string('date_no_cast')->nullable();

            $table->datetime('basic_datetime')->nullable();
            $table->string('datetime_no_cast')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dates');
    }
};
