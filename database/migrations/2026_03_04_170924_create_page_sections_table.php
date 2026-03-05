<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // hero, features, pricing, calendar, custom
            $table->string('title')->nullable();
            $table->json('content')->nullable(); // stores all section data
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('page_sections'); }
};