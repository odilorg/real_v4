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
        Schema::create('amenities', function (Blueprint $table) {
           $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->nullable(); // e.g. Interior, Exterior, Safety, Accessibility
            $table->string('icon')->nullable();     // heroicon / custom icon key
            $table->unsignedInteger('order_column')->default(0);
            $table->json('meta')->nullable();       // extra data if needed
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenities');
    }
};
