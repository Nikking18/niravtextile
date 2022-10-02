<?php

namespace Database\Seeders;

use App\Models\InwordReport;
use Database\Factories\InwordReportFactory;
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
        $this->call([
//            AdminSeeder::class,
//             \App\Models\User::factory(10)->create();
            InwordReport::factory(10)->create(),
        ]);
    }
}
