<?php namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class Pasien extends ResourceController {
    protected $modelName = 'App\\Models\\PasienModel';
    protected $format    = 'json';

    public function index() 
    {
        $data = $this->model->findAll();

        return $this->respond([
            'status' => 200,
            'message' => 'Data pasien berhasil diambil',
            'data' => $data
        ]);
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {
            return $this->failNotFound("Data pasien dengan ID $id tidak ditemukan.");
        }

        return $this->respond([
            'status' => 200,
            'message' => 'Data pasien ditemukan',
            'data' => $data
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true); 

        if (!$this->model->find($id)) {
            return $this->failNotFound("Data pasien dengan ID $id tidak ditemukan.");
        }

        if ($this->model->update($id, $data)) {
            return $this->respond([
                'status'  => 200,
                'message' => "Data pasien ID $id berhasil diubah.",
                'data'    => $data
            ]);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    public function delete($id = null)
    {

        $obat = $this->model->find($id);
        if (!$obat) {
            return $this->failNotFound("Data pasien dengan ID $id tidak ditemukan.");
        }


        if ($this->model->delete($id)) {
            return $this->respondDeleted([
                'status'  => 200,
                'message' => "Data pasien ID $id berhasil dihapus."
            ]);
        }

        return $this->failServerError("Gagal menghapus data.");
    }


    public function create() 
    {
        $data = $this->request->getJSON(true);

        if (empty($data)) {
            return $this->fail('Data kosong atau format tidak sesuai.');
        }


        if (isset($data[0]) && is_array($data[0])) {
            if ($this->model->insertBatch($data)) {
                return $this->respondCreated([
                    'status'  => 201,
                    'message' => 'Beberapa data pasien berhasil ditambahkan',
                    'data'    => $data
                ]);
            }
        } else {
            if ($this->model->insert($data)) {
                return $this->respondCreated([
                    'status'  => 201,
                    'message' => 'Satu data pasien berhasil ditambahkan',
                    'data'    => $data
                ]);
            }
        }

        return $this->failValidationErrors($this->model->errors());
    }

}