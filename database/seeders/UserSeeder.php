<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'ijay1',
            'nama' => 'Ijay Admin',
            'nip' => '1234561',
            'password' => bcrypt('123'),
        ])->assignRole('Admin');

        User::create([
            'username' => 'ijay2',
            'nama' => 'Ijay Pegawai',
            'nip' => '1234562',
            'password' => bcrypt('123'),
        ])->assignRole('Pegawai');
    }
}
