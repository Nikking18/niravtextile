<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Machine::create([
            'machine_number' => 'All',
        ]);

        $machineNumber = 1;
        for ($i = 1; $i <= 35; $i++) {
            Machine::create([
                'machine_number' => $machineNumber++,
            ]);
        }
    }
}
