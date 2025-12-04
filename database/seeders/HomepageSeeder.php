<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomepageSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics'],
            ['name' => 'Fashion'],
            ['name' => 'Groceries'],
            ['name' => 'Home & Living'],
            ['name' => 'Health & Beauty'],
            ['name' => 'Sports'],
            ['name' => 'Automotive'],
            ['name' => 'Books'],
            ['name' => 'Toys'],
            ['name' => 'Gaming'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['slug' => Str::slug($category['name'])],
                ['name' => $category['name'], 'created_at' => now(), 'updated_at' => now()]
            );
        }

        // Products akan ditambahkan oleh seller melalui dashboard
        // Tidak perlu seed products di sini
    }
}