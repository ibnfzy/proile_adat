<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\KategoriArtikelModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;
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
            'judul'        => 'required|min_length[5]|max_length[255]',
            'isi'          => 'required',
            'kategori_id'  => 'required|is_not_unique[kategori_artikel.id]',
            'penulis_id'   => 'required|is_not_unique[users.id]',
            'gambar.*'     => 'if_exist|is_image[gambar.*]|mime_in[gambar.*,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar.*,4096]',
            'video'        => 'if_exist|mime_in[video,video/mp4,video/webm,video/ogg]|max_size[video,51200]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $judul = (string) $this->request->getPost('judul');
        $slug  = $this->generateSlug($judul);

        $uploadedImages = $this->request->getFileMultiple('gambar');
        $storedImages   = $this->processImageUploads($uploadedImages);

        $videoFile     = $this->request->getFile('video');
        $videoFilename = $this->storeVideoFile($videoFile);

        $this->artikelModel->insert([
            'judul'       => $judul,
            'slug'        => $slug,
            'isi'         => (string) $this->request->getPost('isi'),
            'gambar'      => ! empty($storedImages) ? json_encode($storedImages) : null,
            'video'       => $videoFilename,
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

        $artikel['images'] = $this->decodeImageList($artikel['gambar'] ?? null);

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

        $artikel['images'] = $this->decodeImageList($artikel['gambar'] ?? null);

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
            'gambar.*'    => 'if_exist|is_image[gambar.*]|mime_in[gambar.*,image/jpg,image/jpeg,image/png,image/webp]|max_size[gambar.*,4096]',
            'video'       => 'if_exist|mime_in[video,video/mp4,video/webm,video/ogg]|max_size[video,51200]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $judul = (string) $this->request->getPost('judul');
        $slug  = $artikel['slug'];

        if ($artikel['judul'] !== $judul) {
            $slug = $this->generateSlug($judul, $id);
        }

        $existingImages = $this->decodeImageList($artikel['gambar'] ?? null);
        $removeImages   = array_map('strval', (array) $this->request->getPost('remove_images'));

        if (! empty($removeImages)) {
            foreach ($removeImages as $imagePath) {
                $this->deleteUploadedFile($imagePath);
            }
        }

        $remainingImages = array_values(array_filter(
            $existingImages,
            static fn (string $image) => ! in_array($image, $removeImages, true)
        ));

        $newImages   = $this->processImageUploads($this->request->getFileMultiple('gambar'));
        $finalImages = array_values(array_merge($remainingImages, $newImages));

        $videoFile     = $this->request->getFile('video');
        $removeVideo   = (bool) $this->request->getPost('remove_video');
        $videoFilename = $this->storeVideoFile($videoFile, $artikel['video'] ?? null, $removeVideo);

        $updateData = [
            'judul'       => $judul,
            'slug'        => $slug,
            'isi'         => (string) $this->request->getPost('isi'),
            'kategori_id' => (int) $this->request->getPost('kategori_id'),
            'penulis_id'  => (int) $this->request->getPost('penulis_id'),
            'gambar'      => ! empty($finalImages) ? json_encode($finalImages) : null,
        ];

        if ($removeVideo || $videoFilename !== ($artikel['video'] ?? null)) {
            $updateData['video'] = $videoFilename;
        }

        $this->artikelModel->update($id, $updateData);

        return redirect()->to('/Admin/artikel')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function delete(int $id): RedirectResponse
    {
        $artikel = $this->artikelModel->find($id);

        if (! $artikel) {
            throw PageNotFoundException::forPageNotFound('Artikel tidak ditemukan.');
        }

        foreach ($this->decodeImageList($artikel['gambar'] ?? null) as $imagePath) {
            $this->deleteUploadedFile($imagePath);
        }

        $this->deleteUploadedFile($artikel['video'] ?? null);

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

    private function decodeImageList($value): array
    {
        if (empty($value)) {
            return [];
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return array_values(array_filter(array_map('strval', $decoded)));
            }

            return [$value];
        }

        if (is_array($value)) {
            return array_values(array_filter(array_map('strval', $value)));
        }

        return [];
    }

    /**
     * @param array<int, UploadedFile>|null $files
     */
    private function processImageUploads(?array $files): array
    {
        if (empty($files)) {
            return [];
        }

        $storedImages = [];

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            if ($file->getError() === UPLOAD_ERR_NO_FILE || ! $file->isValid()) {
                continue;
            }

            $uploadPath = ROOTPATH . 'public/uploads/artikel';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName, true);

            $storedImages[] = 'artikel/' . $newName;
        }

        return $storedImages;
    }

    private function storeVideoFile(?UploadedFile $file, ?string $existing = null, bool $forceRemove = false): ?string
    {
        if ($forceRemove && $existing) {
            $this->deleteUploadedFile($existing);
            $existing = null;
        }

        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return $existing;
        }

        if (! $file->isValid()) {
            return $existing;
        }

        $uploadPath = ROOTPATH . 'public/uploads/artikel/videos';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName, true);

        $relativePath = 'artikel/videos/' . $newName;

        if ($existing && $existing !== $relativePath) {
            $this->deleteUploadedFile($existing);
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
}
