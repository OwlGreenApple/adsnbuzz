<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        	'name' => 'Puspitasari Nurhidayati',
            'email' => 'puspita.celebgramme@gmail.com',
            'password' => bcrypt('cobadeh'),
            'admin' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'Puspitasari N',
            'email' => 'puspitanurhidayati@gmail.com',
            'password' => bcrypt('cobadeh'),
            'admin' => 0,
            'deposit' => 0,
        ]);
    }
}
