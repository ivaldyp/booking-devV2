<?php

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
	        	'id_user' =>  md5(uniqid()),
	            'username' => "admin",
	            'password' => Hash::make("adminadmin"),
	            'name' => "admin",
	            'user_status' => "1",
	            'user_bidang' => NULL,
	        ], 
	        [
	        	'id_user' =>  md5(uniqid()),
	            'username' => "pegawai",
	            'password' => Hash::make("p1p1p1p1"),
	            'name' => "pegawai",
	            'user_status' => "2",
	            'user_bidang' => "5",
	        ], 
	        [
	        	'id_user' =>  md5(uniqid()),
	            'username' => "umum",
	            'password' => Hash::make("u1u1u1u1"),
	            'name' => "umum",
	            'user_status' => "3",
	            'user_bidang' => "1",
	        ]
    	]);
    }
}
