<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
    		[
    			'full_name' => 'Admin',
                'name' => 'admin',
    			'email' => 'onlineservices.fda@gmail.com',
                'department_id' => 0,
                'role' => 1,
                'role_id' => 1,
                'applicant_name' => 'pms',
                'applicant_phone_no' => '09',
                'applicant_nrc' => '1/(n)',
                'company_name' => 'Company Co.,Ltd',
                'company_registration_no' => '0912345',
                'is_active' => '1',
    			'password' => bcrypt('password'),
    			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
    			'full_name' => 'user',
                'name' => 'user',
    			'email' => 'htayko.securelink@gmail.com',
                'department_id' => 1,
                'role' => 99,
                'role_id' => 3,
                'applicant_name' => 'pms',
                'applicant_phone_no' => '09',
                'applicant_nrc' => '1/(n)',
                'company_name' => 'Company Co.,Ltd',
                'company_registration_no' => '09123456',
                'is_active' => '1',
    			'password' => bcrypt('password'),
    			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    		],
    	]);
    }
}
