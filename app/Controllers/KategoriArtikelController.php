<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriArtikelModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class KategoriArtikelController extends BaseController
{
    protected KategoriArtikelModel $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriArtikelModel();
        helper(['form', 'text', 'url']);
    }

    public function index(): string
    {
        $search = $this->request->getGet('search');

        $model = new KategoriArtikelModel();

        if ($search) {
            $model->like('nama', $search);
        }

        $categories = $model->orderBy('created_at', 'DESC')->findAll();

        return view('admin/kategori_artikel/index', [
            'pageTitle'  => 'Kategori Artikel',
            'categories' => $categories,
            'search'     => $search,
        ]);
    }

    public function create(): string
    {
        return view('admin/kategori_artikel/create', [
            'pageTitle' => 'Tambah Kategori Artikel',
        ]);
    }

    public function store(): RedirectResponse
    {
        $rules = [
            'nama' => 'required|min_length[3]|max_length[100]|is_unique[kategori_artikel.nama]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama = (string) $this->request->getPost('nama');
        $slug = $this->generateSlug($nama);

        $this->kategoriModel->insert([
            'nama' => $nama,
            'slug' => $slug,
        ]);

        return redirect()->to('/Admin/kategori-artikel')->with('success', 'Kategori artikel berhasil ditambahkan.');
    }

    public function edit(int $id): string
    {
        $kategori = $this->kategoriModel->find($id);

        if (! $kategori) {
            throw PageNotFoundException::forPageNotFound('Kategori artikel tidak ditemukan.');
        }

        return view('admin/kategori_artikel/edit', [
            'pageTitle' => 'Edit Kategori Artikel',
            'kategori'  => $kategori,
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $kategori = $this->kategoriModel->find($id);

        if (! $kategori) {
            throw PageNotFoundException::forPageNotFound('Kategori artikel tidak ditemukan.');
        }

        $rules = [
            'nama' => "required|min_length[3]|max_length[100]|is_unique[kategori_artikel.nama,id,{$id}]"
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nama = (string) $this->request->getPost('nama');
        $slug = $kategori['slug'];

        if ($kategori['nama'] !== $nama) {
            $slug = $this->generateSlug($nama, $id);
        }

        $this->kategoriModel->update($id, [
            'nama' => $nama,
            'slug' => $slug,
        ]);

        return redirect()->to('/Admin/kategori-artikel')->with('success', 'Kategori artikel berhasil diperbarui.');
    }

    public function delete(int $id): RedirectResponse
    {
        $kategori = $this->kategoriModel->find($id);

        if (! $kategori) {
            throw PageNotFoundException::forPageNotFound('Kategori artikel tidak ditemukan.');
        }

        $this->kategoriModel->delete($id);

        return redirect()->to('/Admin/kategori-artikel')->with('success', 'Kategori artikel berhasil dihapus.');
    }

    private function generateSlug(string $nama, ?int $ignoreId = null): string
    {
        $baseSlug = url_title($nama, '-', true);
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
        $builder = $this->kategoriModel->builder();
        $builder->where('slug', $slug);

        if ($ignoreId !== null) {
            $builder->where('id !=', $ignoreId);
        }

        return $builder->countAllResults() > 0;
    }
}
