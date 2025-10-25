<?php

namespace App\Controllers;

use App\Models\PengaturanModel;

class WebsiteController extends BaseController
{
    protected PengaturanModel $pengaturanModel;
    private ?string $musicUrl = null;

    public function __construct()
    {
        $this->pengaturanModel = new PengaturanModel();
    }

    public function index(): string
    {
        return $this->viewWithMusic('web/index');
    }

    public function informasi(): string
    {
        return $this->viewWithMusic('web/informasi');
    }

    public function informasiDetail(): string
    {
        return $this->viewWithMusic('web/informasi-detail');
    }

    public function artikel(): string
    {
        return $this->viewWithMusic('web/artikel');
    }

    public function artikelDetail(): string
    {
        return $this->viewWithMusic('web/artikel-detail');
    }

    private function viewWithMusic(string $view, array $data = []): string
    {
        $data['musicUrl'] = $this->getMusicUrl();

        return view($view, $data);
    }

    private function getMusicUrl(): string
    {
        if ($this->musicUrl !== null) {
            return $this->musicUrl;
        }

        $this->musicUrl = (string) ($this->pengaturanModel->getValue('music_url') ?? '');

        return $this->musicUrl;
    }
}
