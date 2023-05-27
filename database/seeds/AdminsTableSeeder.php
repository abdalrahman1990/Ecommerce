<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         *  Create an Admin Account
         */
        App\Admin::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => \Hash::make('password')
        ]);
    }
}
