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
        $mediaType = (string) $this->request->getPost('media_type');
        $mediaType = in_array($mediaType, ['image', 'video'], true) ? $mediaType : null;

        $rules = [
            'judul'      => 'required|min_length[3]|max_length[255]',
            'deskripsi'  => 'permit_empty|string',
            'media_type' => 'required|in_list[image,video]',
        ];

        if ($mediaType === 'image') {
            $rules['gambar'] = 'uploaded[gambar]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,4096]';
        } elseif ($mediaType === 'video') {
            $rules['video'] = 'uploaded[video]|mime_in[video,video/mp4,video/webm,video/ogg]|max_size[video,51200]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile = $this->request->getFile('gambar');
        $videoFile = $this->request->getFile('video');

        $errors = [];

        if ($mediaType === 'image') {
            if (! $this->isNoFile($videoFile)) {
                $errors['video'] = 'Pilih jenis media "Video" jika ingin mengunggah berkas video.';
            }
        } elseif ($mediaType === 'video') {
            if (! $this->isNoFile($imageFile)) {
                $errors['gambar'] = 'Pilih jenis media "Foto" jika ingin mengunggah berkas gambar.';
            }
        }

        if ($errors !== []) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $imageFilename = '';
        $videoFilename = '';

        if ($mediaType === 'image') {
            $imageFilename = $this->handleUploadedImage($imageFile);
        } elseif ($mediaType === 'video') {
            $videoFilename = $this->handleUploadedVideo($videoFile);
        }

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

        $mediaTypeInput = (string) $this->request->getPost('media_type');
        if (in_array($mediaTypeInput, ['image', 'video'], true)) {
            $mediaType = $mediaTypeInput;
        } elseif (! empty($photo['video'])) {
            $mediaType = 'video';
        } elseif (! empty($photo['gambar'])) {
            $mediaType = 'image';
        } else {
            $mediaType = null;
        }

        $rules = [
            'judul'      => "required|min_length[3]|max_length[255]|is_unique[galeri.judul,id,{$id}]",
            'deskripsi'  => 'permit_empty|string',
            'media_type' => 'required|in_list[image,video]',
        ];

        if ($mediaType === 'image') {
            $rules['gambar'] = ($photo['gambar'] ? 'if_exist|' : 'uploaded[gambar]|') . 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar,4096]';
        } elseif ($mediaType === 'video') {
            $rules['video'] = ($photo['video'] ? 'if_exist|' : 'uploaded[video]|') . 'mime_in[video,video/mp4,video/webm,video/ogg]|max_size[video,51200]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageFile = $this->request->getFile('gambar');
        $videoFile = $this->request->getFile('video');

        $errors = [];

        if ($mediaType === 'image') {
            if (! $this->isNoFile($videoFile)) {
                $errors['video'] = 'Pilih jenis media "Video" jika ingin mengunggah berkas video.';
            }
        } elseif ($mediaType === 'video') {
            if (! $this->isNoFile($imageFile)) {
                $errors['gambar'] = 'Pilih jenis media "Foto" jika ingin mengunggah berkas gambar.';
            }
        }

        if ($errors !== []) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $updateData = [
            'judul'     => (string) $this->request->getPost('judul'),
            'deskripsi' => (string) $this->request->getPost('deskripsi'),
        ];

        if ($mediaType === 'image') {
            $imageFilename          = $this->handleUploadedImage($imageFile, $photo['gambar'] ?? null);
            $updateData['gambar']    = $imageFilename;
            $updateData['video']     = null;

            if (! empty($photo['video'])) {
                $this->deleteUploadedFile($photo['video']);
            }
        } elseif ($mediaType === 'video') {
            $videoFilename          = $this->handleUploadedVideo($videoFile, $photo['video'] ?? null);
            $updateData['video']    = $videoFilename;
            $updateData['gambar']   = null;

            if (! empty($photo['gambar'])) {
                $this->deleteUploadedFile($photo['gambar']);
            }
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
