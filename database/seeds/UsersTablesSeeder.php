<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'abdalrahman',
            'email' => 'a@a.com',
            'phone' => '07724018497',
            'user_type' => 0,
            'password' => Hash::make('12121212'),
            'department_id' => \App\Models\Department::inRandomOrder()->first()->id,

        ]);
        factory(\App\User::Class,10)->create();
    }
}
