<?php

// database/migrations/2024_01_01_000001_create_services_table.php
// Tutorial #Migration: Database schema definition
// Tutorial #26: Connect to MySQL Database

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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('short_description', 500);
            $table->string('image')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('category');
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('tags')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index(['status', 'featured']);
            $table->index('category');
            $table->index('sort_order');
            $table->index('created_at');
            $table->fullText(['title', 'description', 'short_description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

    public function down(): void
    {
        Schema::dropIfExists('service_inquiries');
    }
};

// database/migrations/2024_01_01_000007_create_portfolio_items_table.php
// Tutorial #61: One to Many Relationship
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('client_name');
            $table->string('project_url')->nullable();
            $table->json('images'); // Array of image paths
            $table->json('technologies')->nullable(); // Tech stack used
            $table->date('completion_date');
            $table->integer('duration_months')->nullable();
            $table->enum('status', ['completed', 'ongoing', 'paused'])->default('completed');
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['service_id', 'featured']);
            $table->index('completion_date');
            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_items');
    }
};





// database/migrations/2024_01_01_000010_create_settings_table.php
// For application settings
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('general');
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, boolean, integer, json
            $table->text('description')->nullable();
            $table->boolean('autoload')->default(false);
            $table->timestamps();
            
            $table->index(['group', 'key']);
            $table->index('autoload');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};