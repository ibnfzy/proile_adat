<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InformasiModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class InformasiController extends BaseController
{
    protected InformasiModel $informasiModel;

    public function __construct()
    {
        $this->informasiModel = new InformasiModel();
        helper(['form', 'text', 'url']);
    }

    public function index(): string
    {
        $search = $this->request->getGet('search');

        $builder = $this->informasiModel->orderBy('created_at', 'DESC');

        if ($search) {
            $builder->like('judul', $search);
        }

        return view('admin/informasi/index', [
            'pageTitle'   => 'Informasi',
            'informations' => $builder->findAll(),
            'search'      => $search,
        ]);
    }

    public function create(): string
    {
        return view('admin/informasi/create', [
            'pageTitle' => 'Tambah Informasi',
        ]);
    }

    public function store(): RedirectResponse
    {
        $rules = [
            'judul'  => 'required|min_length[3]|max_length[255]|is_unique[informasi.judul]',
            'konten' => 'required',
            'emoji'  => 'required|max_length[10]',
            'gambar' => 'permit_empty|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $judul = (string) $this->request->getPost('judul');
        $slug  = $this->generateSlug($judul);

        $this->informasiModel->insert([
            'judul'  => $judul,
            'slug'   => $slug,
            'konten' => (string) $this->request->getPost('konten'),
            'emoji'  => (string) $this->request->getPost('emoji'),
            'gambar' => $this->request->getPost('gambar') ?: null,
        ]);

        return redirect()->to('/Admin/informasi')->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function show(int $id): string
    {
        $informasi = $this->informasiModel->find($id);

        if (! $informasi) {
            throw PageNotFoundException::forPageNotFound('Informasi tidak ditemukan.');
        }

        return view('admin/informasi/show', [
            'pageTitle' => 'Preview Informasi',
            'informasi' => $informasi,
        ]);
    }

    public function edit(int $id): string
    {
        $informasi = $this->informasiModel->find($id);

        if (! $informasi) {
            throw PageNotFoundException::forPageNotFound('Informasi tidak ditemukan.');
        }

        return view('admin/informasi/edit', [
            'pageTitle' => 'Edit Informasi',
            'informasi' => $informasi,
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $informasi = $this->informasiModel->find($id);

        if (! $informasi) {
            throw PageNotFoundException::forPageNotFound('Informasi tidak ditemukan.');
        }

        $rules = [
            'judul'  => "required|min_length[3]|max_length[255]|is_unique[informasi.judul,id,{$id}]",
            'konten' => 'required',
            'emoji'  => 'required|max_length[10]',
            'gambar' => 'permit_empty|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $judul = (string) $this->request->getPost('judul');
        $slug  = $informasi['slug'];

        if ($informasi['judul'] !== $judul) {
            $slug = $this->generateSlug($judul, $id);
        }

        $this->informasiModel->update($id, [
            'judul'  => $judul,
            'slug'   => $slug,
            'konten' => (string) $this->request->getPost('konten'),
            'emoji'  => (string) $this->request->getPost('emoji'),
            'gambar' => $this->request->getPost('gambar') ?: null,
        ]);

        return redirect()->to('/Admin/informasi')->with('success', 'Informasi berhasil diperbarui.');
    }

    public function delete(int $id): RedirectResponse
    {
        $informasi = $this->informasiModel->find($id);

        if (! $informasi) {
            throw PageNotFoundException::forPageNotFound('Informasi tidak ditemukan.');
        }

        $this->informasiModel->delete($id);

        return redirect()->to('/Admin/informasi')->with('success', 'Informasi berhasil dihapus.');
    }

    private function generateSlug(string $judul, ?int $ignoreId = null): string
    {
        $baseSlug = url_title($judul, '-', true);
        $slug     = $baseSlug;
        $counter  = 2;

        while ($this->slugExists($slug, $ignoreId)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $builder = $this->informasiModel->builder();
        $builder->where('slug', $slug);

        if ($ignoreId !== null) {
            $builder->where('id !=', $ignoreId);
        }

        return $builder->countAllResults() > 0;
    }
}
