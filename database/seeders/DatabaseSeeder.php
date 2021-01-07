<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@test.test',
            'password' => Hash::make('admin'),
            'admin' => true,
            'about' => 'Admin Almighty'
        ]);

        User::factory()->times(5)->create();

        Category::factory()->times(20)->create();
    }
}
