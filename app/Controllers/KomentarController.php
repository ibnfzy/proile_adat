<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\InformasiModel;
use App\Models\KomentarModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\I18n\Time;

class KomentarController extends BaseController
{
    private KomentarModel $komentarModel;
    private ArtikelModel $artikelModel;
    private InformasiModel $informasiModel;

    public function __construct()
    {
        $this->komentarModel   = new KomentarModel();
        $this->artikelModel    = new ArtikelModel();
        $this->informasiModel  = new InformasiModel();
    }

    public function index(): string
    {
        $filter = (string) $this->request->getGet('show');
        $status = $filter === 'approved' ? 'approved' : 'pending';

        $comments = $this->komentarModel
            ->where('status', $status)
            ->orderBy($status === 'pending' ? 'created_at' : 'checked_at', 'DESC')
            ->findAll();

        return view('admin/komentar/index', [
            'pageTitle'         => 'Moderasi Komentar',
            'comments'          => $this->formatComments($comments),
            'isShowingApproved' => $status === 'approved',
        ]);
    }

    public function updateStatus(int $id): RedirectResponse
    {
        $comment = $this->komentarModel->find($id);

        if (! $comment) {
            throw PageNotFoundException::forPageNotFound('Komentar tidak ditemukan.');
        }

        $status = (string) $this->request->getPost('status');

        if (! in_array($status, ['approved', 'rejected'], true)) {
            return redirect()->back()->with('error', 'Status komentar tidak valid.');
        }

        if ($comment['status'] === $status) {
            return redirect()->back()->with('message', 'Tidak ada perubahan status yang dilakukan.');
        }

        $updateData = [
            'status'     => $status,
            'checked_by' => (int) ($this->session->get('userId') ?? 0) ?: null,
            'checked_at' => Time::now('Asia/Makassar', 'id_ID')->toDateTimeString(),
        ];

        $this->komentarModel->update($id, $updateData);

        $message = $status === 'approved'
            ? 'Komentar berhasil disetujui dan kini tampil di halaman publik.'
            : 'Komentar telah ditandai tidak layak tampil.';

        $redirectUrl = '/Admin/komentar';
        if ((string) $this->request->getGet('show') === 'approved') {
            $redirectUrl .= '?show=approved';
        }

        return redirect()->to($redirectUrl)->with('message', $message);
    }

    /**
     * @param array<int, array<string, mixed>> $comments
     * @return array<int, array<string, mixed>>
     */
    private function formatComments(array $comments): array
    {
        if ($comments === []) {
            return [];
        }

        $userIds = [];
        foreach ($comments as $comment) {
            if (! empty($comment['checked_by'])) {
                $userIds[] = (int) $comment['checked_by'];
            }
        }
        $userIds = array_values(array_unique(array_filter($userIds)));

        $userNames = [];
        if ($userIds !== []) {
            $userModel = new UserModel();
            $users     = $userModel->select(['id', 'nama_lengkap', 'username'])->whereIn('id', $userIds)->findAll();

            foreach ($users as $user) {
                $userNames[(int) $user['id']] = $user['nama_lengkap'] ?? $user['username'] ?? 'Admin';
            }
        }

        return array_map(function (array $comment) use ($userNames) {
            $comment['content_title'] = $this->resolveContentTitle(
                (string) $comment['content_type'],
                (int) $comment['content_id']
            );

            $comment['created_at_human'] = $this->formatDateTime($comment['created_at'] ?? null);
            $comment['checked_at_human'] = $this->formatDateTime($comment['checked_at'] ?? null);

            $checkedBy = $comment['checked_by'] ?? null;
            $comment['checked_by_name'] = $checkedBy ? ($userNames[(int) $checkedBy] ?? 'Admin') : null;

            return $comment;
        }, $comments);
    }

    private function resolveContentTitle(string $type, int $contentId): string
    {
        if ($type === 'artikel') {
            $artikel = $this->artikelModel->find($contentId);
            return $artikel['judul'] ?? 'Artikel tidak ditemukan';
        }

        if ($type === 'informasi') {
            $informasi = $this->informasiModel->find($contentId);
            return $informasi['judul'] ?? 'Informasi tidak ditemukan';
        }

        return 'Konten tidak dikenal';
    }

    private function formatDateTime(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            return Time::parse($value, 'Asia/Makassar', 'id_ID')->format('d M Y H:i');
        } catch (\Throwable $exception) {
            return $value;
        }
    }
}
