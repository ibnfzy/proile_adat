<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\InformasiModel;
use App\Models\KomentarModel;
use CodeIgniter\HTTP\ResponseInterface;

class CommentController extends BaseController
{
    private KomentarModel $komentarModel;
    private ArtikelModel $artikelModel;
    private InformasiModel $informasiModel;

    public function __construct()
    {
        $this->komentarModel   = new KomentarModel();
        $this->artikelModel    = new ArtikelModel();
        $this->informasiModel  = new InformasiModel();

        helper(['text']);
    }

    public function index(): ResponseInterface
    {
        $type = (string) $this->request->getGet('type');
        $id   = (int) $this->request->getGet('id');

        if (! in_array($type, ['artikel', 'informasi'], true) || $id <= 0) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['message' => 'Parameter komentar tidak valid.']);
        }

        $comments = $this->komentarModel->getApprovedFor($type, $id);

        $payload = array_map(static function (array $comment) {
            return [
                'id'         => (int) ($comment['id'] ?? 0),
                'nama'       => (string) ($comment['nama'] ?? ''),
                'komentar'   => (string) ($comment['komentar'] ?? ''),
                'created_at' => (string) ($comment['created_at'] ?? ''),
            ];
        }, $comments);

        return $this->response->setJSON($payload);
    }

    public function create(): ResponseInterface
    {
        $rules = [
            'content_type'    => 'required|in_list[artikel,informasi]',
            'content_id'      => 'required|is_natural_no_zero',
            'nama'            => 'required|min_length[3]|max_length[100]',
            'email'           => 'permit_empty|valid_email|max_length[255]',
            'komentar'        => 'required|min_length[5]|max_length[1000]',
            'captcha_a'       => 'required|is_natural',
            'captcha_b'       => 'required|is_natural',
            'captcha_answer'  => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_UNPROCESSABLE_ENTITY)
                ->setJSON([
                    'message' => 'Data komentar tidak valid.',
                    'errors'  => $this->validator->getErrors(),
                ]);
        }

        $type          = (string) $this->request->getPost('content_type');
        $contentId     = (int) $this->request->getPost('content_id');
        $captchaA      = (int) $this->request->getPost('captcha_a');
        $captchaB      = (int) $this->request->getPost('captcha_b');
        $captchaAnswer = (int) $this->request->getPost('captcha_answer');

        if ($captchaA + $captchaB !== $captchaAnswer) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_FORBIDDEN)
                ->setJSON(['message' => 'Jawaban captcha tidak sesuai.']);
        }

        if (! $this->contentExists($type, $contentId)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON(['message' => 'Konten tujuan komentar tidak ditemukan.']);
        }

        $this->komentarModel->insert([
            'content_type' => $type,
            'content_id'   => $contentId,
            'nama'         => (string) $this->request->getPost('nama'),
            'email'        => $this->request->getPost('email') ?: null,
            'komentar'     => (string) $this->request->getPost('komentar'),
            'status'       => 'pending',
            'ip_address'   => (string) $this->request->getIPAddress(),
            'user_agent'   => (string) ($this->request->getUserAgent()?->getAgentString() ?? ''),
        ]);

        return $this->response
            ->setStatusCode(ResponseInterface::HTTP_CREATED)
            ->setJSON(['message' => 'Komentar berhasil dikirim dan menunggu moderasi admin.']);
    }

    private function contentExists(string $type, int $id): bool
    {
        if ($type === 'artikel') {
            return $this->artikelModel->find($id) !== null;
        }

        if ($type === 'informasi') {
            return $this->informasiModel->find($id) !== null;
        }

        return false;
    }
}
