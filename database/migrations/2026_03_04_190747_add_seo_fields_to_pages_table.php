<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('is_published');
            $table->string('favicon')->nullable()->after('logo');
            $table->string('seo_title')->nullable()->after('favicon');
            $table->text('seo_description')->nullable()->after('seo_title');
            $table->string('seo_keywords')->nullable()->after('seo_description');
            $table->string('og_title')->nullable()->after('seo_keywords');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
            $table->string('twitter_card')->default('summary_large_image')->after('og_image');
            $table->string('twitter_site')->nullable()->after('twitter_card');
            $table->string('canonical_url')->nullable()->after('twitter_site');
            $table->json('schema_markup')->nullable()->after('canonical_url');
        });
    }
    public function down(): void {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'logo','favicon','seo_title','seo_description','seo_keywords',
                'og_title','og_description','og_image','twitter_card',
                'twitter_site','canonical_url','schema_markup',
            ]);
        });
    }
};