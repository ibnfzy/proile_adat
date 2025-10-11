<?php

namespace App\Models;

use CodeIgniter\Model;

class InformasiModel extends Model
{
    protected $table            = 'informasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'emoji',
    ];

    protected $useTimestamps = true;
    protected $dateFormat  = 'datetime';
    protected $createdField       = 'created_at';
    protected $updatedField       = 'updated_at';
}
