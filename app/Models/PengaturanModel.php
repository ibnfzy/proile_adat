<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table            = 'pengaturan';
    protected $primaryKey       = 'key';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['key', 'value'];
    protected $useTimestamps    = false;

    public function getValue(string $key, ?string $default = null): ?string
    {
        $setting = $this->find($key);

        if (! $setting) {
            return $default;
        }

        return $setting['value'] ?? $default;
    }
}
