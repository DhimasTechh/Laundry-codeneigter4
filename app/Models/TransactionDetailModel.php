<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailModel extends Model
{
    protected $table            = 'transaction_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'transaction_id',
        'product_id',
        'jumlah',
        'diskon',
        'subtotal_harga',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil detail transaksi beserta nama produk.
     */
    public function getDetailWithProduct(int $transactionId): array
    {
        return $this->db->table('transaction_detail td')
            ->select('td.*, p.nama, p.foto, p.harga')
            ->join('product p', 'p.id = td.product_id', 'left')
            ->where('td.transaction_id', $transactionId)
            ->get()
            ->getResultArray();
    }
}
