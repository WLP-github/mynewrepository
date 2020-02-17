<?php

use Illuminate\Database\Seeder;

class AppointmentTypeSlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('appointment_type_slots')->insert([
        	[
        		'appointment_cat_id' => 1,
        		'slot_id' => '{2}',
        	],
        	[
        		'appointment_cat_id' => 2,
        		'slot_id' => '{2}',
        	],
        	[
        		'appointment_cat_id' => 3,
        		'slot_id' => '{1, 3}',
        	],
        	[
        		'appointment_cat_id' => 4,
        		'slot_id' => '{2}',
        	],
        	[
        		'appointment_type_id' => 5,
        		'slot_id' => '{2}',
        	],
        	[
        		'appointment_type_id' => 6,
        		'slot_id' => '{2}',
        	],
        ]);
    }
}
