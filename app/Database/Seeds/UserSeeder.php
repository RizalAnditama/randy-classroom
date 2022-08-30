<?php

namespace App\Database\Seeds;

use App\Models\ModelUser;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $modelUser = new ModelUser();

        $data = [
            [
                'name' => 'Muhammad Rizal Anditama Nugraha',
                'username' => 'endme',
                'email' => 'rizalanditama@gmail.com',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'murid',
            ],
            [
                'name' => 'Sinung Kalimu Nugroho',
                'username' => 'sinung',
                'email' => 'sinung@gmail.com',
                'password' => password_hash('12345678', PASSWORD_DEFAULT),
                'role' => 'guru',
            ],
        ];

        $this->db->table('user')->insert($data);
    }
}
