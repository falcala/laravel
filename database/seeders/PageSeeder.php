<?php
namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::firstOrCreate(
            ['slug' => 'welcome'],
            ['title' => 'Welcome Page', 'is_published' => true]
        );
    }
}