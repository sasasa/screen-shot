<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'name' => '管理者',
                'email' => 'masaakisaeki@gmail.com',
                'password' => bcrypt('password'),
                'fail_count' => 0,
                'pass_update_date' => null,
            ],
        ];
        foreach($admins as $admin) {
            Admin::create($admin);
        }
    }
}
