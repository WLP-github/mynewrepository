<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
        	[
        		'name' => 'Nay Pyi Taw FDA (Cosmetic Department)',
                'sort_order' => 1,
                'entry_date' => now(),
        	],
            [
                'name' => 'Nay Pyi Taw FDA (Medical Device)',
                'sort_order' => 2,
                'entry_date' => now(),
            ],
            [
                'name' => 'Nay Pyi Taw FDA (Medical Device Grouping)',
                'sort_order' => 3,
                'entry_date' => now(),
            ],
        ]);
    }
}
