<?php

namespace App\Controllers;

class WebsiteController extends BaseController
{
    public function index(): string
    {
        return view('web/index');
    }

    public function informasi(): string
    {
        return view('web/informasi');
    }

    public function informasiDetail(): string
    {
        return view('web/informasi-detail');
    }

    public function artikel(): string
    {
        return view('web/artikel');
    }

    public function artikelDetail(): string
    {
        return view('web/artikel-detail');
    }
}
