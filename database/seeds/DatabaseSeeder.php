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
        $this->call(RoomAmenityTableSeeder::class);
        $this->call(RoomDetailTableSeeder::class);
        $this->call(RoomRuleTableSeeder::class);
        $this->call(RoomSpaceTableSeeder::class);
        $this->call(RoomTypeTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(RoomTableSeeder::class);
        $this->call(ApartmentTableSeeder::class);
    }
}
