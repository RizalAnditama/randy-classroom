<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run()
    {
        $this->call('MapelSeeder');
        $this->call('KelasSeeder');
        $this->call('GuruSeeder');
        $this->call('MuridSeeder');
        $this->call('MateriSeeder');
    }
}
