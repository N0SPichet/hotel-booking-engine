<?php

use App\Admin;
use App\Models\Role;
use App\Models\UserVerification;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User
        $role_user = Role::where('name', 'User')->first();
        $role_admin = Role::where('name', 'Admin')->first();
        $role_author = Role::where('name', 'Author')->first();
        $genders = ['1', '2'];

        $user_verifiation = new UserVerification;
        $user_verifiation->save();
        $user = new User;
        $faker = Faker::create();
        $user->user_fname = "Alex";
        $user->user_lname = "N0S";
        $user->email = "user1@example.com";
        $user->password = bcrypt('user');
        $user->user_verifications_id = $user_verifiation->id;
        $user->user_gender = $genders[rand(0, count($genders)-1)];
        $user->user_description = $faker->text(300);
        $user->user_score = '10';
        $user->save();
        $user->roles()->attach($role_user);

        $user_verifiation = new UserVerification;
        $user_verifiation->save();
        $user = new User;
        $faker = Faker::create();
        $user->user_fname = $faker->firstName;
        $user->user_lname = $faker->lastName;
        $user->email = "user2@example.com";
        $user->password = bcrypt('user');
        $user->user_verifications_id = $user_verifiation->id;
        $user->user_gender = $genders[rand(0, count($genders)-1)];
        $user->user_description = $faker->text(300);
        $user->user_score = '10';
        $user->save();
        $user->roles()->attach($role_user);

        $user_verifiation = new UserVerification;
        $user_verifiation->save();
        $user = new User;
        $faker = Faker::create();
        $user->user_fname = $faker->firstName;
        $user->user_lname = $faker->lastName;
        $user->email = "user3@example.com";
        $user->password = bcrypt('user');
        $user->user_verifications_id = $user_verifiation->id;
        $user->user_gender = $genders[rand(0, count($genders)-1)];
        $user->user_description = $faker->text(300);
        $user->user_score = '10';
        $user->save();
        $user->roles()->attach($role_user);

        //Admin
        $admin = new Admin;
        $admin->name = "Admin";
        $admin->email = "admin@example.com";
        $admin->password = bcrypt('admina');
        $admin->save();
    }
}
