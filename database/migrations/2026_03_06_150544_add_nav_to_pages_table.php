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
        Schema::table('pages', function (Blueprint $table) {
            $table->json('nav_items')->nullable()->after('is_published');
            $table->string('nav_position', 20)->default('normal')->after('nav_items'); // normal|sticky|fixed
            $table->boolean('nav_enabled')->default(false)->after('nav_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['nav_items', 'nav_position', 'nav_enabled']);
        });
    }
};
