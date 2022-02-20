<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use CodeIgniter\API\ResponseTrait;
use App\Models\ModelPegawai;

class Pegawai extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        $this->model = new ModelPegawai();
    }

    public function index()
    {
        $data = $this->model->getPegawai();

        $response = [
            'status' => 200,
            'error' => null,
            'message' => null,
            'data' => $data
        ];

        return $this->respond($response);
    }

    public function show($id)
    {
        $data = $this->model->getPegawai($id);
        if ($data) {
            $response = [
                'status' => 200,
                'error' => null,
                'message' => null,
                'data' => $data
            ];

            return $this->respond($response);
        } else {
            return $this->failNotFound("Data tidak ditemukan untuk id $id");
        }
    }

    public function create()
    {
        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email')
        ];

        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
            'message' => [
                'success' => 'Berhasil memasukkan data pegawai'
            ]
        ];

        return $this->respondCreated($response);
    }

    public function update($id)
    {
        $isExist = $this->model->find($id);
        if (!$isExist) {
            return $this->failNotFound("Data tidak ditemukan");
        }

        $data = $this->request->getRawInput();
        $data['id'] = $id;

        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }

        $response = [
            'status' => 200,
            'error' => null,
            'message' => [
                'success' => "Berhasil mengubah data pegawai dengan id $id"
            ]
        ];

        return $this->respondUpdated($response);
    }

    public function delete($id)
    {
        $isExist = $this->model->find($id);
        if ($isExist) {
            $this->model->delete($id);

            $response = [
                'status' => 200,
                'error' => null,
                'message' => [
                    'success' => "Berhasil menghapus data pegawai dengan id $id"
                ]
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound("Data tidak ditemukan");
        }
    }
}
