<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ModelOtentikasi extends Model
{
    protected $table            = 'otentikasi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['email', 'password'];

    public function getEmail($email)
    {
        $data = $this->where('email', $email)->first();
        if (!$data) {
            throw new Exception("Data otentikasi tidak ditemukan");
        }
        return $data;
    }
}
