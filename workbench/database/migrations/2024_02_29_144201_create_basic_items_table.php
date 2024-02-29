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
        Schema::create('basic_items', function (Blueprint $table): void {
            $table->id();

            $table->string('title');

            $table->string('basic_text');
            
            $table->date('basic_date');
            $table->string('date_no_cast');
            
            $table->string('basic_email');
            
            $table->string('basic_textarea');
            
            $table->string('long_textarea');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basic_items');
    }
};
