<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $table            = 'komentar';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'content_type',
        'content_id',
        'nama',
        'email',
        'komentar',
        'status',
        'ip_address',
        'user_agent',
        'checked_by',
        'checked_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * @param string $type
     * @param int    $contentId
     *
     * @return array<int, array<string, mixed>>
     */
    public function getApprovedFor(string $type, int $contentId): array
    {
        return $this->where([
            'content_type' => $type,
            'content_id'   => $contentId,
            'status'       => 'approved',
        ])
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }
}
