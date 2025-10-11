<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\GaleriModel;
use App\Models\InformasiModel;

class AdminController extends BaseController
{
    public function index()
    {
        $artikelModel   = new ArtikelModel();
        $informasiModel = new InformasiModel();
        $galeriModel    = new GaleriModel();

        return view('admin/index', [
            'pageTitle'      => 'Dashboard',
            'artikelCount'   => $artikelModel->countAll(),
            'informasiCount' => $informasiModel->countAll(),
            'galeriCount'    => $galeriModel->countAll(),
        ]);
    }
}
