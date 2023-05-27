<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        
        /**
         * first generate category so we can
         * add it to the products
         */
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
    }
}
