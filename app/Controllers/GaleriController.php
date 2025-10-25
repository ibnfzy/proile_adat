<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GaleriModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;
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
            'gambar'    => 'if_exist|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,4096]',
            'video'     => 'if_exist|mime_in[video,video/mp4,video/webm,video/ogg]|max_size[video,51200]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile = $this->request->getFile('gambar');
        $videoFile = $this->request->getFile('video');

        if ($this->isNoFile($imageFile) && $this->isNoFile($videoFile)) {
            return redirect()->back()->withInput()->with('errors', [
                'media' => 'Unggah minimal satu gambar atau video untuk galeri.',
            ]);
        }

        $imageFilename = $this->handleUploadedImage($imageFile);
        $videoFilename = $this->handleUploadedVideo($videoFile);

        $this->galeriModel->insert([
            'judul'     => (string) $this->request->getPost('judul'),
            'deskripsi' => (string) $this->request->getPost('deskripsi'),
            'gambar'    => $imageFilename,
            'video'     => $videoFilename,
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
            'video'     => 'if_exist|mime_in[video,video/mp4,video/webm,video/ogg]|max_size[video,51200]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile   = $this->request->getFile('gambar');
        $videoFile   = $this->request->getFile('video');
        $removeVideo = (bool) $this->request->getPost('remove_video');

        $imageFilename = $this->handleUploadedImage($imageFile, $photo['gambar'] ?? null);
        $videoFilename = $this->handleUploadedVideo($videoFile, $photo['video'] ?? null, $removeVideo);

        if ($imageFilename === null && $videoFilename === null) {
            return redirect()->back()->withInput()->with('errors', [
                'media' => 'Minimal satu media (gambar atau video) harus tersedia.',
            ]);
        }

        $updateData = [
            'judul'     => (string) $this->request->getPost('judul'),
            'deskripsi' => (string) $this->request->getPost('deskripsi'),
        ];

        if ($imageFilename !== ($photo['gambar'] ?? null)) {
            $updateData['gambar'] = $imageFilename;
        }

        if ($removeVideo || $videoFilename !== ($photo['video'] ?? null)) {
            $updateData['video'] = $videoFilename;
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
            $this->deleteUploadedFile($photo['gambar']);
        }

        $this->deleteUploadedFile($photo['video'] ?? null);

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

    private function handleUploadedImage(?UploadedFile $file, ?string $existingFilename = null): ?string
    {
        if ($this->isNoFile($file)) {
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

        $relativePath = 'galeri/' . $newName;

        if ($existingFilename && $existingFilename !== $relativePath) {
            $this->deleteUploadedFile($existingFilename);
        }

        return $relativePath;
    }

    private function handleUploadedVideo(?UploadedFile $file, ?string $existingFilename = null, bool $forceRemove = false): ?string
    {
        if ($forceRemove && $existingFilename) {
            $this->deleteUploadedFile($existingFilename);
            $existingFilename = null;
        }

        if ($this->isNoFile($file)) {
            return $existingFilename;
        }

        if (! $file->isValid()) {
            return $existingFilename;
        }

        $uploadPath = ROOTPATH . 'public/uploads/galeri/videos';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName, true);

        $relativePath = 'galeri/videos/' . $newName;

        if ($existingFilename && $existingFilename !== $relativePath) {
            $this->deleteUploadedFile($existingFilename);
        }

        return $relativePath;
    }

    private function deleteUploadedFile(?string $filename): void
    {
        if (empty($filename) || preg_match('#^https?://#i', (string) $filename)) {
            return;
        }

        $cleanName = str_replace('\\', '/', trim((string) $filename));
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

    private function isNoFile(?UploadedFile $file): bool
    {
        return $file === null || $file->getError() === UPLOAD_ERR_NO_FILE;
    }
}
