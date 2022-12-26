<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableDataSeeder extends Seeder
{
    public $seedData = [
        [
            'role_name' => 'Agents',
            'description' => 'Agents of the platform',
        ],
        [
            'role_name' => 'Students',
            'description' => 'Students of the platform'
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert($this->seedData);
    }
}
