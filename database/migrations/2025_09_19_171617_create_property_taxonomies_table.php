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
        Schema::create('property_taxonomy', function (Blueprint $table) {
           $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->foreignId('taxonomy_id')->constrained()->cascadeOnDelete();
            $table->primary(['property_id', 'taxonomy_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_taxonomies');
    }
};
