<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory(10)->create();
         Post::factory(500)->create(['created_at' => Carbon::now()->subDays(random_int(1, 10))]);
    }
}
