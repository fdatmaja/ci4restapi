<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelOtentikasi;
use Config\Services;
use Exception;

class Otentikasi extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        $validation = Services::validation();
        $aturan = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Silahkan masukkan email',
                    'valid_email' => 'Email tidak valid'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan masukkan password'
                ]
            ]
        ];

        $validation->setRules($aturan);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $model = new ModelOtentikasi();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $data = $model->getEmail($email);

        if ($data['password'] != md5($password)) {
            return $this->fail("Password tidak sesuai");
        }

        helper('jwt');
        $response = [
            'status' => 200,
            'message' => 'Otentikasi berhasil',
            'data' => [
                'email' => $data['email']
            ],
            'access_token' => createJWT($email)
        ];

        return $this->respond($response);
    }

    public function decrypt()
    {
        $access_token = $this->request->getPost('access_token');
        try {
            helper('jwt');
            $data = decryptJWT($access_token);
        } catch (Exception $e) {
            return Services::response()->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $response = [
            'status' => 200,
            'message' => 'Decrypt berhasil',
            'data' => $data
        ];

        return $this->respond($response);
    }
}
