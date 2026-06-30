<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transaction';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'total_harga',
        'alamat',
        'ongkir',
        'status',
        'metode_pembayaran',
        'nama_penerima',
        'telepon',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil semua transaksi milik user tertentu beserta jumlah item.
     */
    public function getByUsername(string $username): array
    {
        return $this->where('username', $username)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Statistik untuk admin dashboard.
     */
    public function getStats(): array
    {
        $db = \Config\Database::connect();

        return [
            'total_transaksi'  => $this->countAll(),
            'total_pendapatan' => $db->table('transaction')->selectSum('total_harga')->get()->getRow()->total_harga ?? 0,
            'pending'          => $this->where('status', 0)->countAllResults(),
            'diproses'         => $this->where('status', 1)->countAllResults(),
            'selesai'          => $this->where('status', 2)->countAllResults(),
        ];
    }
}
