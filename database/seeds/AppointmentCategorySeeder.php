<?php

use Illuminate\Database\Seeder;

class AppointmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appointment_categories')->insert([
            [
                'name' => 'Cosmetic Notification',
                'short_name' => 'COS',
                'department_id' => 1,
                'slot_id' => '[2]',
                'entry_date' => now(),
            ],
            [
                'name' => 'Cosmetic Manufacturing',
                'short_name' => 'COS',
                'department_id' => 1,
                'slot_id' => '[2]',
                'entry_date' => now(),
            ],
            [
                'name' => 'Import Recommendation',
                'short_name' => 'MD',
                'department_id' => 2,
                'slot_id' => '[1,3]',
                'entry_date' => now(),
            ],
            [
                'name' => 'A (family)',
                'short_name' => 'MD',
                'department_id' => 3,
                'slot_id' => '[2]',
                'entry_date' => now(),
            ],
            [
                'name' => 'B (System)',
                'short_name' => 'MD',                
                'department_id' => 3,
                'slot_id' => '[2]',
                'entry_date' => now(),
            ],
            [
                'name' => 'C (kit/group)',
                'short_name' => 'MD',
                'department_id' => 3,
                'slot_id' => '[2]',
                'entry_date' => now(),
            ]
        ]);
    }
}
