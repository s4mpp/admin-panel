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
        Schema::table('basic_items', function (Blueprint $table) {
            $table->string('title_uppercase');
            $table->string('title_with_default_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('basic_items', function (Blueprint $table) {
            $table->dropColumn('title_uppercase');
            $table->dropColumn('title_with_default_text');
        });
    }
};
