<?php

namespace Database\Seeders;

use App\Models\User;
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
        $userList = [
            [
                "name" => "Sai",
                "password" => bcrypt('admin123'),
                "email" => "saiponethaaung@gmail.com",
                "updated_at" => "2021-09-14 20:05:58",
                "created_at" => "2021-09-14 20:05:58",
                "auth_code" => "XVOMEQ6DEFV3KSUN",
                "auth_created" => "2021-09-14 20:05:58"
            ],
        ];

        foreach ($userList as $user) {
            User::insert($user);
        }
    }
}
