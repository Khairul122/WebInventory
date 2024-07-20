<?php

namespace App\Controllers;

use App\Models\MesinModel;
use CodeIgniter\Controller;

class Mesin extends Controller
{
    public function index()
    {
        return view('mesin');
    }

    public function muatData()
    {
        $model = new MesinModel();
        $data = $model->findAll();
        echo json_encode($data);
    }

    public function tambah()
    {
        $model = new MesinModel();
        $data = [
            'nama_mesin' => $this->request->getPost('namaMesin')
        ];
        $model->insert($data);
        echo json_encode(['status' => 'success']);
    }

    public function edit()
    {
        $model = new MesinModel();
        $id = $this->request->getPost('id_mesin');
        $data = [
            'nama_mesin' => $this->request->getPost('nama_mesin')
        ];
        $model->update($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function hapus()
    {
        $model = new MesinModel();
        $id = $this->request->getPost('id_mesin');
        $model->delete($id);
        echo json_encode(['status' => 'success']);
    }
}
