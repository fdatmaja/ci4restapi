<?php

namespace App\Database\Seeds;

use App\Models\ModelPegawai;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\Fabricator;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        $fabricator = new Fabricator(ModelPegawai::class);
        $fabricator->setOverrides(['created_at' => Time::now(), 'updated_at' => Time::now()]);
        $data = $fabricator->make(10);

        $this->db->table('pegawai')->insertBatch($data);
    }
}
