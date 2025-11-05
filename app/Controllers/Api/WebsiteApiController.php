<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\GaleriModel;
use App\Models\InformasiModel;
use CodeIgniter\I18n\Time;
use Exception;

class WebsiteApiController extends BaseController
{
    protected ArtikelModel $artikelModel;
    protected InformasiModel $informasiModel;
    protected GaleriModel $galeriModel;

    public function __construct()
    {
        $this->artikelModel   = new ArtikelModel();
        $this->informasiModel = new InformasiModel();
        $this->galeriModel    = new GaleriModel();

        helper(['text', 'url']);
    }

    public function artikel()
    {
        $articles = $this->artikelModel
            ->select('artikel.*, kategori_artikel.slug as kategori_slug, kategori_artikel.nama as kategori_nama, users.nama_lengkap as penulis_nama')
            ->join('kategori_artikel', 'kategori_artikel.id = artikel.kategori_id', 'left')
            ->join('users', 'users.id = artikel.penulis_id', 'left')
            ->orderBy('artikel.created_at', 'DESC')
            ->findAll();

        $data = array_map(function (array $article) {
            $images       = $this->decodeImageList($article['gambar'] ?? null);
            $imageUrls    = array_map([$this, 'buildMediaUrl'], $images);
            $primaryImage = $imageUrls[0] ?? '';

            return [
                'id'           => (int) ($article['id'] ?? 0),
                'title'        => (string) ($article['judul'] ?? ''),
                'slug'         => (string) ($article['slug'] ?? ''),
                'excerpt'      => $this->generateExcerpt($article['isi'] ?? ''),
                'content'      => (string) ($article['isi'] ?? ''),
                'image'        => $primaryImage,
                'images'       => $imageUrls,
                'video'        => $this->buildMediaUrl($article['video'] ?? null),
                'date'         => $this->formatDate($article['created_at'] ?? null),
                'category'     => (string) ($article['kategori_slug'] ?? 'lainnya'),
                'categoryName' => (string) ($article['kategori_nama'] ?? ''),
                'author'       => (string) ($article['penulis_nama'] ?? 'Admin'),
            ];
        }, $articles);

        return $this->response->setJSON($data);
    }

    public function informasi()
    {
        $informasiList = $this->informasiModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = array_map(fn(array $informasi) => [
            'id'      => (int) ($informasi['id'] ?? 0),
            'title'   => (string) ($informasi['judul'] ?? ''),
            'slug'    => (string) ($informasi['slug'] ?? ''),
            'icon'    => (string) ($informasi['emoji'] ?? 'ℹ️'),
            'excerpt' => $this->generateExcerpt($informasi['konten'] ?? ''),
            'content' => (string) ($informasi['konten'] ?? ''),
            'image'   => $this->buildImageUrl($informasi['gambar'] ?? null),
            'date'    => $this->formatDate($informasi['created_at'] ?? null),
            'created_at' => $informasi['created_at'],
            'updated_at' => $informasi['updated_at']
        ], $informasiList);

        return $this->response->setJSON($data);
    }

    public function galeri()
    {
        $photos = $this->galeriModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = array_map(fn(array $photo) => [
            'id'          => (int) ($photo['id'] ?? 0),
            'title'       => (string) ($photo['judul'] ?? ''),
            'image'       => $this->buildMediaUrl($photo['gambar'] ?? null),
            'video'       => $this->buildMediaUrl($photo['video'] ?? null),
            'description' => (string) ($photo['deskripsi'] ?? ''),
        ], $photos);

        return $this->response->setJSON($data);
    }

    private function generateExcerpt(?string $content, int $limit = 160): string
    {
        $plain = trim(strip_tags((string) $content));

        if ($plain === '') {
            return '';
        }

        return trim(character_limiter($plain, $limit));
    }

    private function buildImageUrl(?string $path): string
    {
        return $this->buildMediaUrl($path);
    }

    private function buildMediaUrl($path): string
    {
        if (empty($path)) {
            return '';
        }

        if (is_array($path)) {
            $path = $path[0] ?? '';
        }

        if (preg_match('#^https?://#i', (string) $path)) {
            return (string) $path;
        }

        $cleanPath = ltrim((string) $path, '/');

        if (strpos($cleanPath, 'uploads/') === 0) {
            $cleanPath = substr($cleanPath, strlen('uploads/')) ?: '';
        }

        if ($cleanPath === '') {
            return '';
        }

        return base_url('uploads/' . $cleanPath);
    }

    private function decodeImageList($value): array
    {
        if (empty($value)) {
            return [];
        }

        if (is_array($value)) {
            return array_values(array_filter(array_map('strval', $value)));
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return array_values(array_filter(array_map('strval', $decoded)));
            }

            return [(string) $value];
        }

        return [];
    }

    private function formatDate(?string $date): string
    {
        if (empty($date)) {
            return date('Y-m-d');
        }

        try {
            return Time::parse($date)->toDateString();
        } catch (Exception $exception) {
            $timestamp = strtotime((string) $date);

            if ($timestamp !== false) {
                return date('Y-m-d', $timestamp);
            }
        }

        return date('Y-m-d');
    }
}