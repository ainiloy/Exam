<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{

    public function run()
{
    $admin = [
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('77889900')
    ];
    Admin::create($admin);
}
}
