<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LayananModel;

class Layanan extends BaseController
{
    protected LayananModel $layananModel;

    public function __construct()
    {
        helper(['form', 'number']);
        $this->layananModel = new LayananModel();
    }

    public function index()
    {
        return view('admin/layanan/index', [
            'products' => $this->layananModel->findAll(),
        ]);
    }

    public function create()
    {
        $dataFoto = $this->request->getFile('foto');

        $dataForm = [
            'nama'      => $this->request->getPost('nama'),
            'harga'     => $this->request->getPost('harga'),
            'jumlah'    => $this->request->getPost('jumlah'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        if ($dataFoto && $dataFoto->isValid() && !$dataFoto->hasMoved()) {
            $fileName = $dataFoto->getRandomName();
            $dataFoto->move(FCPATH . 'img/', $fileName);
            $dataForm['foto'] = $fileName;
        }

        $this->layananModel->insert($dataForm);

        return redirect()->to(site_url('admin/layanan'))->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dataProduk = $this->layananModel->find($id);
        if (!$dataProduk) {
            return redirect()->to(site_url('admin/layanan'))->with('failed', 'Data layanan tidak ditemukan.');
        }

        $dataForm = [
            'nama'      => $this->request->getPost('nama'),
            'harga'     => $this->request->getPost('harga'),
            'jumlah'    => $this->request->getPost('jumlah'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        // Ganti foto jika ada file baru yang di-upload
        $dataFoto = $this->request->getFile('foto');
        if ($dataFoto && $dataFoto->isValid() && !$dataFoto->hasMoved()) {
            // Hapus foto lama jika ada
            if (!empty($dataProduk['foto']) && file_exists(FCPATH . 'img/' . $dataProduk['foto'])) {
                unlink(FCPATH . 'img/' . $dataProduk['foto']);
            }
            $fileName = $dataFoto->getRandomName();
            $dataFoto->move(FCPATH . 'img/', $fileName);
            $dataForm['foto'] = $fileName;
        }

        $this->layananModel->update($id, $dataForm);

        return redirect()->to(site_url('admin/layanan'))->with('success', 'Layanan berhasil diubah.');
    }

    public function delete($id)
    {
        $dataProduk = $this->layananModel->find($id);
        if (!$dataProduk) {
            return redirect()->to(site_url('admin/layanan'))->with('failed', 'Data layanan tidak ditemukan.');
        }

        if (!empty($dataProduk['foto']) && file_exists(FCPATH . 'img/' . $dataProduk['foto'])) {
            unlink(FCPATH . 'img/' . $dataProduk['foto']);
        }

        $this->layananModel->delete($id);

        return redirect()->to(site_url('admin/layanan'))->with('success', 'Layanan berhasil dihapus.');
    }
}
