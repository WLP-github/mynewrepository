<?php

use Illuminate\Database\Seeder;

class SlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slots')->insert([
        	[
        		'name' => 'အချိန်( ၉:၀၀ မှ ၁၂:ဝဝ နာရီ အထိ)',
        	],
        	[
        		'name' => 'အချိန်( ၉:၀၀ မှ ၃:ဝဝ နာရီ အထိ)'
        	],
        	[
        		'name' => 'အချိန် (၁၃:ဝဝ မှ ၁၅:၃၀ နာရီ အထိ)'
        	],
        ]);
    }
}
