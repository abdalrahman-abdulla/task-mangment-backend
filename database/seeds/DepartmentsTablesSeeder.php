<?php

use Illuminate\Database\Seeder;

class DepartmentsTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Department::Class,10)->create();
    }
}
