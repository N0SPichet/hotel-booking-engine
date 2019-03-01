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
    	$this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(AddressTableSeeder::class);
        $this->call(DiaryComponentTableSeeder::class);
        $this->call(RoomComponentTableSeeder::class);
        $this->call(ApartmentTableSeeder::class);
        $this->call(RoomTableSeeder::class);
        $this->call(RentalTableSeeder::class);
        $this->call(DiaryTableSeeder::class);
    }
}
