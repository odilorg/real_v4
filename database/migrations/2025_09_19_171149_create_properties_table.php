<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            // Ownership
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();

            // Content
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Enums (stored as string)
            $table->string('property_type'); // enum: apartment, house, land, commercial, room_share, etc.
            $table->string('status')->default('draft'); // draft|needs_review|published|archived
            $table->string('ownership_type')->nullable();

            // Specs
            $table->unsignedSmallInteger('year_built')->nullable();
            $table->decimal('area_total', 10, 2)->nullable();
            $table->decimal('area_living', 10, 2)->nullable();
            $table->unsignedSmallInteger('bedrooms')->nullable();
            $table->decimal('bathrooms', 3, 1)->nullable(); // 1.5, 2.0 etc.
            $table->unsignedSmallInteger('floors')->nullable();
            $table->unsignedSmallInteger('floor_no')->nullable();
            $table->string('parking')->nullable();     // enum-ish string (garage, street, none)
            $table->string('heating')->nullable();     // central, gas, electric...
            $table->string('furnishing')->nullable();  // unfurnished|partly|fully
            $table->string('orientation')->nullable();
            $table->string('energy_class')->nullable();
            $table->json('utilities')->nullable();     // arbitrary extra flags

            // Geo: store lat/lng + POINT (if your MySQL supports spatial)
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            // Laravel supports spatial columns; if your connection is MySQL 8+, this works:
           

            // Address
            $table->string('country', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 120)->nullable();
            $table->string('district', 120)->nullable();
            $table->string('street', 180)->nullable();
            $table->string('house_no', 50)->nullable();
            $table->string('postal_code', 20)->nullable();

            // Publishing
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Hot indexes
            $table->index(['status', 'published_at']);
            $table->index(['city', 'property_type']);
            $table->index(['lat', 'lng']);
        });
        // // Optional spatial indexes (MySQL only)
        // if (Schema::getConnection()->getDriverName() === 'mysql') {
        //     DB::statement('CREATE SPATIAL INDEX properties_geolocation_spx ON properties (geolocation)');
        // }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
