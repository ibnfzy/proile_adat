<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriArtikelModel extends Model
{
    protected $table            = 'kategori_artikel';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama', 'slug'];
    protected $useTimestamps    = true;
    protected $returnType       = 'array';
}
