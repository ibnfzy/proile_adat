<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GaleriModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class GaleriController extends BaseController
{
    protected GaleriModel $galeriModel;

    public function __construct()
    {
        $this->galeriModel = new GaleriModel();
        helper(['form', 'text', 'url']);
    }

    public function index(): string
    {
        $search = $this->request->getGet('search');

        $builder = $this->galeriModel->orderBy('created_at', 'DESC');

        if ($search) {
            $builder->like('judul', $search);
        }

        return view('admin/galeri/index', [
            'pageTitle' => 'Galeri',
            'photos'    => $builder->findAll(),
            'search'    => $search,
        ]);
    }

    public function create(): string
    {
        return view('admin/galeri/create', [
            'pageTitle' => 'Tambah Foto',
        ]);
    }

    public function store(): RedirectResponse
    {
        $rules = [
            'judul'     => 'required|min_length[3]|max_length[255]',
            'deskripsi' => 'permit_empty|string',
            'gambar'    => 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,4096]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile     = $this->request->getFile('gambar');
        $imageFilename = $this->handleUploadedImage($imageFile);

        $this->galeriModel->insert([
            'judul'     => (string) $this->request->getPost('judul'),
            'deskripsi' => (string) $this->request->getPost('deskripsi'),
            'gambar'    => $imageFilename,
        ]);

        return redirect()->to('/Admin/galeri')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function edit(int $id): string
    {
        $photo = $this->galeriModel->find($id);

        if (! $photo) {
            throw PageNotFoundException::forPageNotFound('Foto tidak ditemukan.');
        }

        return view('admin/galeri/edit', [
            'pageTitle' => 'Edit Foto',
            'photo'     => $photo,
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        $photo = $this->galeriModel->find($id);

        if (! $photo) {
            throw PageNotFoundException::forPageNotFound('Foto tidak ditemukan.');
        }

        $rules = [
            'judul'     => "required|min_length[3]|max_length[255]|is_unique[galeri.judul,id,{$id}]",
            'deskripsi' => 'permit_empty|string',
            'gambar'    => 'if_exist|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,4096]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile     = $this->request->getFile('gambar');
        $imageFilename = $this->handleUploadedImage($imageFile, $photo['gambar'] ?? null);

        $updateData = [
            'judul'     => (string) $this->request->getPost('judul'),
            'deskripsi' => (string) $this->request->getPost('deskripsi'),
        ];

        if ($imageFilename !== null) {
            $updateData['gambar'] = $imageFilename;
        }

        $this->galeriModel->update($id, $updateData);

        return redirect()->to('/Admin/galeri')->with('success', 'Foto berhasil diperbarui.');
    }

    public function delete(int $id): RedirectResponse
    {
        $photo = $this->galeriModel->find($id);

        if (! $photo) {
            throw PageNotFoundException::forPageNotFound('Foto tidak ditemukan.');
        }

        if (! empty($photo['gambar'])) {
            $this->deleteUploadedImage($photo['gambar']);
        }

        $this->galeriModel->delete($id);

        return redirect()->to('/Admin/galeri')->with('success', 'Foto berhasil dihapus.');
    }

    public function publicIndex(): string
    {
        $search = $this->request->getGet('search');

        $builder = $this->galeriModel->orderBy('created_at', 'DESC');

        if ($search) {
            $builder->like('judul', $search);
        }

        return view('galeri/index', [
            'pageTitle' => 'Galeri Foto',
            'photos'    => $builder->findAll(),
            'search'    => $search,
        ]);
    }

    private function handleUploadedImage($file, ?string $existingFilename = null): ?string
    {
        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return $existingFilename;
        }

        if (! $file->isValid()) {
            return $existingFilename;
        }

        $uploadPath = ROOTPATH . 'public/uploads/galeri';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName, true);

        if ($existingFilename) {
            $this->deleteUploadedImage($existingFilename);
        }

        return 'galeri/' . $newName;
    }

    private function deleteUploadedImage(?string $filename): void
    {
        if (empty($filename) || preg_match('#^https?://#i', (string) $filename)) {
            return;
        }

        $cleanName = str_replace('\\', '/', (string) $filename);
        $cleanName = ltrim($cleanName, '/');

        if (strpos($cleanName, 'uploads/') === 0) {
            $cleanName = substr($cleanName, strlen('uploads/')) ?: '';
        }

        if ($cleanName === '') {
            return;
        }

        $filePath = ROOTPATH . 'public/uploads/' . $cleanName;

        if (is_file($filePath)) {
            @unlink($filePath);
        }
    }
}
