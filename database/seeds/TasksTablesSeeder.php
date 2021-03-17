<?php

use Illuminate\Database\Seeder;

class TasksTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Task::Class,10)->create();
    }
}
