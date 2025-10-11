<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\KategoriArtikelModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class ArtikelController extends BaseController
{
    protected ArtikelModel $artikelModel;
    protected KategoriArtikelModel $kategoriModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
        $this->kategoriModel = new KategoriArtikelModel();
        $this->userModel     = new UserModel();
        helper(['form', 'text', 'url']);
    }

    public function index(): string
    {
        $search = $this->request->getGet('search');

        $builder = $this->artikelModel
            ->select('artikel.*, kategori_artikel.nama as kategori_nama, users.nama_lengkap as penulis_nama')
            ->join('kategori_artikel', 'kategori_artikel.id = artikel.kategori_id', 'left')
            ->join('users', 'users.id = artikel.penulis_id', 'left')
            ->orderBy('artikel.created_at', 'DESC');

        if ($search) {
            $builder->like('artikel.judul', $search);
        }

        $articles = $builder->findAll();

        return view('admin/artikel/index', [
            'pageTitle' => 'Artikel',
            'articles'  => $articles,
            'search'    => $search,
        ]);
    }

    public function create(): string
    {
        return view('admin/artikel/create', [
            'pageTitle'  => 'Tambah Artikel',
            'categories' => $this->kategoriModel->orderBy('nama', 'ASC')->findAll(),
            'authors'    => $this->userModel->orderBy('nama_lengkap', 'ASC')->findAll(),
        ]);
    }

    public function store(): RedirectResponse
    {
        $rules = [
            'judul'       => 'required|min_length[5]|max_length[255]',
            'isi'         => 'required',
            'kategori_id' => 'required|is_not_unique[kategori_artikel.id]',
            'penulis_id'  => 'required|is_not_unique[users.id]',
            'gambar'      => 'permit_empty|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $judul = (string) $this->request->getPost('judul');
        $slug  = $this->generateSlug($judul);

        $this->artikelModel->insert([
            'judul'       => $judul,
            'slug'        => $slug,
            'isi'         => (string) $this->request->getPost('isi'),
            'gambar'      => $this->request->getPost('gambar') ?: null,
            'kategori_id' => (int) $this->request->getPost('kategori_id'),
            'penulis_id'  => (int) $this->request->getPost('penulis_id'),
        ]);

        return redirect()->to('/Admin/artikel')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function show(int $id): string
    {
        $artikel = $this->artikelModel
            ->select('artikel.*, kategori_artikel.nama as kategori_nama, users.nama_lengkap as penulis_nama')
            ->join('kategori_artikel', 'kategori_artikel.id = artikel.kategori_id', 'left')
            ->join('users', 'users.id = artikel.penulis_id', 'left')
            ->find($id);

        if (! $artikel) {
            throw PageNotFoundException::forPageNotFound('Artikel tidak ditemukan.');
        }

        return view('admin/artikel/show', [
            'pageTitle' => 'Preview Artikel',
            'artikel'   => $artikel,
        ]);
    }

    public function edit(int $id): string
    {
        $artikel = $this->artikelModel->find($id);

        if (! $artikel) {
            throw PageNotFoundException::forPageNotFound('Artikel tidak ditemukan.');
        }

        return view('admin/artikel/edit', [
            'pageTitle'  => 'Edit Artikel',
            'artikel'    => $artikel,
            'categories' => $this->kategoriModel->orderBy('nama', 'ASC')->findAll(),
            'authors'    => $this->userModel->orderBy('nama_lengkap', 'ASC')->findAll(),
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $artikel = $this->artikelModel->find($id);

        if (! $artikel) {
            throw PageNotFoundException::forPageNotFound('Artikel tidak ditemukan.');
        }

        $rules = [
            'judul'       => "required|min_length[5]|max_length[255]|is_unique[artikel.judul,id,{$id}]",
            'isi'         => 'required',
            'kategori_id' => 'required|is_not_unique[kategori_artikel.id]',
            'penulis_id'  => 'required|is_not_unique[users.id]',
            'gambar'      => 'permit_empty|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $judul = (string) $this->request->getPost('judul');
        $slug  = $artikel['slug'];

        if ($artikel['judul'] !== $judul) {
            $slug = $this->generateSlug($judul, $id);
        }

        $this->artikelModel->update($id, [
            'judul'       => $judul,
            'slug'        => $slug,
            'isi'         => (string) $this->request->getPost('isi'),
            'gambar'      => $this->request->getPost('gambar') ?: null,
            'kategori_id' => (int) $this->request->getPost('kategori_id'),
            'penulis_id'  => (int) $this->request->getPost('penulis_id'),
        ]);

        return redirect()->to('/Admin/artikel')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function delete(int $id): RedirectResponse
    {
        $artikel = $this->artikelModel->find($id);

        if (! $artikel) {
            throw PageNotFoundException::forPageNotFound('Artikel tidak ditemukan.');
        }

        $this->artikelModel->delete($id);

        return redirect()->to('/Admin/artikel')->with('success', 'Artikel berhasil dihapus.');
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
        $builder = $this->artikelModel->builder();
        $builder->where('slug', $slug);

        if ($ignoreId !== null) {
            $builder->where('id !=', $ignoreId);
        }

        return $builder->countAllResults() > 0;
    }
}
