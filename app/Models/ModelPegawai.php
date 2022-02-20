<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPegawai extends Model
{
    protected $table            = 'pegawai';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama', 'email'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $validationRules = [
        'nama' => 'required',
        'email' => 'required|valid_email'
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Silahkan masukkan nama'
        ],
        'email' => [
            'required' => 'Silahkan masukkan email',
            'valid_email' => 'Email tidak valid'
        ]
    ];

    protected $builder;

    public function initialize()
    {
        $db = db_connect();
        $this->builder = $db->table($this->table);
    }

    public function getPegawai($id = null)
    {
        $this->builder->select('id, nama, email');

        if ($id != null) {
            $this->builder->where('id', $id);
        } else {
            $this->builder->orderBy('id', 'ASC');
        }

        $query = $this->builder->get();
        return $query->getResult();
    }
}
