<?php

use App\Role;
use App\User;
use App\UserVerification;
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
        $role_user = Role::where('name', 'User')->first();
        $role_admin = Role::where('name', 'Admin')->first();
        $role_author = Role::where('name', 'Author')->first();

        $user_verifiation = new UserVerification;
        $user_verifiation->save();
        $user = new User;
        $user->user_fname = "Alex";
        $user->user_lname = "N0S";
        $user->email = "admin@example.com";
        $user->password = bcrypt('admin');
        $user->user_verifications_id = $user_verifiation->id;
        $user->save();
        $user->roles()->attach($role_admin);

        $user_verifiation = new UserVerification;
        $user_verifiation->save();
        $user = new User;
        $user->user_fname = "User";
        $user->user_lname = "one";
        $user->email = "user1@example.com";
        $user->password = bcrypt('user');
        $user->user_verifications_id = $user_verifiation->id;
        $user->save();
        $user->roles()->attach($role_user);

        $user_verifiation = new UserVerification;
        $user_verifiation->save();
        $user = new User;
        $user->user_fname = "User";
        $user->user_lname = "two";
        $user->email = "user2@example.com";
        $user->password = bcrypt('user');
        $user->user_verifications_id = $user_verifiation->id;
        $user->save();
        $user->roles()->attach($role_user);
    }
}
