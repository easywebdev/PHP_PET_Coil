<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(DesignsTableSeeder::class);
        $this->command->info('The table Design filled');

        $this->call(MaterialsTableSeeder::class);
        $this->command->info('The table Material filled');

        $this->call(WiresTableSeeder::class);
        $this->command->info('The table Wire filled');

        $this->call(CoilsTableSeeder::class);
        $this->command->info('The table Coils filled');
    }
}

class DesignsTableSeeder extends Seeder
{
    public function run()
    {
        // Delete previous data
        DB::table('coil_designs')->delete();

        // Add 2 new rows
        DB::table('coil_designs')->insert([
            'name'    => 'D-10-12',
            'inner_d' => 10,
            'outer_d' => 12.5,
            'length'  => 9.8,
        ]);

        DB::table('coil_designs')->insert([
            'name'    => 'D-19-30',
            'inner_d' => 19.4,
            'outer_d' => 30,
            'length'  => 24,
        ]);
    }
}

class MaterialsTableSeeder extends Seeder
{
    public function run()
    {
        // Delete previous data
        DB::table('coil_materials')->delete();

        // Add 2 new rows
        DB::table('coil_materials')->insert([
            'name'        => 'Cu',
            'density'     => 8900,
            'resistivity' => 1.72E-8,
            'alphaT'      => 0.0038,
        ]);

        DB::table('coil_materials')->insert([
            'name'        => 'Al',
            'density'     => 2712,
            'resistivity' => 2.80E-8,
            'alphaT'      => 0.0043
        ]);
    }
}

class WiresTableSeeder extends Seeder
{
    public function run()
    {
        // Delete previous data
        DB::table('coil_wires')->delete();

        // Add 2 new rows
        $materialID = DB::table('coil_materials')->where('name', 'Cu')->value('id');

        DB::table('coil_wires')->insert([
            'name'         => 'Cu-0.1',
            'conductor_d'  => 0.09,
            'full_d'       => 0.1,
            'materials_id' => $materialID,
        ]);

        DB::table('coil_wires')->insert([
            'name'         => 'Cu-0.26',
            'conductor_d'  => 0.25,
            'full_d'       => 0.26,
            'materials_id' => $materialID,
        ]);

        $materialID = DB::table('coil_materials')->where('name', 'Al')->value('id');
        DB::table('coil_wires')->insert([
            'name'         => 'Al-0.26',
            'conductor_d'  => 0.25,
            'full_d'       => 0.26,
            'materials_id' => $materialID,
        ]);

    }
}

class CoilsTableSeeder extends Seeder
{
    public function run()
    {
        // Delete previous data
        DB::table('coil_coils')->delete();

        // Add 2 new rows
        $designID = DB::table('coil_designs')->where('name', 'D-10-12')->value('id');
        $wireID = DB::table('coil_wires')->where('name', 'Cu-0.1')->value('id');
        DB::table('coil_coils')->insert([
            'name'       => 'H-27-58',
            'designs_id' => $designID,
            'wires_id'   => $wireID,
        ]);

        $designID = DB::table('coil_designs')->where('name', 'D-19-30')->value('id');
        $wireID = DB::table('coil_wires')->where('name', 'Cu-0.26')->value('id');
        DB::table('coil_coils')->insert([
            'name'       => 'H-41-85',
            'designs_id' => $designID,
            'wires_id'   => $wireID,
        ]);
    }
}
