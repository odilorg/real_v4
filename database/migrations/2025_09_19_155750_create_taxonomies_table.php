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
        Schema::create('taxonomies', function (Blueprint $table) {
            $table->id();
            $table->string('type');               // e.g. property_type | category | tag | city | district
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('parent_id')->nullable()->constrained('taxonomies')->nullOnDelete(); // for hierarchies (city -> district, category tree)
            $table->unsignedInteger('order_column')->default(0);
            $table->json('meta')->nullable();     // arbitrary: color, code, ext ids
            $table->timestamps();
            $table->softDeletes();

            $table->index(['type', 'name']);
            $table->index(['type', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxonomies');
    }
};
