<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'General', 'slug' => 'general'],
            ['name' => 'News', 'slug' => 'news'],
            ['name' => 'Help', 'slug' => 'help'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
