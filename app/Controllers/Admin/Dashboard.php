<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use Config\Database;

/**
 * Admin Dashboard Controller
 *
 * Mengelola halaman seller panel:
 *  - index()        : Overview / Ringkasan
 *  - pesanan()      : Daftar semua pesanan dari buyer
 *  - penghasilan()  : Laporan pendapatan & grafik
 *  - updateStatus() : Update status transaksi
 *
 * ─── CART LIBRARY (CodeIgniter 4 Built-in) ────────────────────────────────
 *  Digunakan di TransaksiController untuk keranjang belanja guest.
 *  Cart library diakses via: $cart = service('cart');
 *
 *  Metode tersedia:
 *   $cart->insert([             // Tambah item ke keranjang
 *       'id'      => $id,
 *       'qty'     => 1,
 *       'price'   => $harga,
 *       'name'    => $nama,
 *       'options' => ['foto' => $foto],
 *   ]);
 *
 *   $cart->update([             // Ubah quantity item
 *       'rowid' => $rowid,
 *       'qty'   => $newQty,
 *   ]);
 *
 *   $cart->total();             // Hitung total harga
 *   $cart->contents();          // Ambil semua isi keranjang
 *   $cart->remove($rowid);      // Hapus satu item dari keranjang
 *   $cart->destroy();           // Kosongkan seluruh keranjang
 * ──────────────────────────────────────────────────────────────────────────
 */
class Dashboard extends BaseController
{
    protected TransactionModel $transactionModel;
    protected TransactionDetailModel $transactionDetailModel;

    public function __construct()
    {
        helper(['number', 'form']);
        $this->transactionModel       = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    // ─────────────────────────────────────────────────────────────────────
    // HALAMAN UTAMA — Overview ringkasan bisnis
    // ─────────────────────────────────────────────────────────────────────
    public function index()
    {
        $transactions = $this->transactionModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        foreach ($transactions as &$trx) {
            $trx['details'] = $this->transactionDetailModel->getDetailWithProduct($trx['id']);
        }
        unset($trx);

        return view('admin/dashboard/index', [
            'stats'        => $this->transactionModel->getStats(),
            'transactions' => $transactions,
            'metodeStat'   => $this->getMetodeStat(),
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────
    // HALAMAN PESANAN — Semua pesanan dari buyer/guest
    // ─────────────────────────────────────────────────────────────────────
    public function pesanan()
    {
        $filterStatus = $this->request->getGet('status') ?? 'all';

        $query = $this->transactionModel->orderBy('created_at', 'DESC');

        if ($filterStatus !== 'all' && is_numeric($filterStatus)) {
            $query->where('status', (int) $filterStatus);
        }

        $transactions = $query->findAll();

        foreach ($transactions as &$trx) {
            $trx['details'] = $this->transactionDetailModel->getDetailWithProduct($trx['id']);
        }
        unset($trx);

        // Hitung jumlah per status untuk tab
        $countByStatus = [
            0 => $this->transactionModel->where('status', 0)->countAllResults(),
            1 => $this->transactionModel->where('status', 1)->countAllResults(),
            2 => $this->transactionModel->where('status', 2)->countAllResults(),
        ];

        return view('admin/pesanan/index', [
            'transactions'  => $transactions,
            'filterStatus'  => $filterStatus,
            'countByStatus' => $countByStatus,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────
    // HALAMAN PENGHASILAN — Laporan pendapatan & statistik
    // ─────────────────────────────────────────────────────────────────────
    public function penghasilan()
    {
        $db = Database::connect();

        $transactions = $this->transactionModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Total pendapatan keseluruhan
        $totalPendapatan = array_sum(array_column($transactions, 'total_harga'));

        // Pendapatan dari pesanan selesai saja
        $pendapatanSelesai = array_sum(
            array_column(
                array_filter($transactions, fn ($t) => (int) $t['status'] === 2),
                'total_harga'
            )
        );

        // Pendapatan dari yang sedang diproses
        $pendapatanProses = array_sum(
            array_column(
                array_filter($transactions, fn ($t) => (int) $t['status'] === 1),
                'total_harga'
            )
        );

        // Rata-rata nilai pesanan
        $totalTrx        = count($transactions);
        $avgOrderValue   = $totalTrx > 0 ? $totalPendapatan / $totalTrx : 0;

        // Data bulanan — 6 bulan terakhir
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthTS   = strtotime("-{$i} months");
            $year      = date('Y', $monthTS);
            $month     = date('m', $monthTS);
            $monthName = date('M', $monthTS);

            $row = $db->table('transaction')
                ->select('SUM(total_harga) as total, COUNT(*) as jumlah')
                ->where('YEAR(created_at)', $year)
                ->where('MONTH(created_at)', $month)
                ->get()
                ->getRowArray();

            $monthlyData[] = [
                'bulan'  => $monthName,
                'total'  => (float) ($row['total'] ?? 0),
                'jumlah' => (int)   ($row['jumlah'] ?? 0),
            ];
        }

        // Top layanan terlaris dari transaction_detail
        $topLayanan = $db->table('transaction_detail td')
            ->select('p.nama, SUM(td.jumlah) as total_terjual, SUM(td.subtotal_harga) as total_pendapatan')
            ->join('product p', 'p.id = td.product_id', 'left')
            ->groupBy('td.product_id')
            ->orderBy('total_terjual', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        return view('admin/penghasilan/index', [
            'transactions'      => $transactions,
            'totalPendapatan'   => $totalPendapatan,
            'pendapatanSelesai' => $pendapatanSelesai,
            'pendapatanProses'  => $pendapatanProses,
            'avgOrderValue'     => $avgOrderValue,
            'monthlyData'       => $monthlyData,
            'metodeStat'        => $this->getMetodeStat(),
            'topLayanan'        => $topLayanan,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────
    // UPDATE STATUS TRANSAKSI
    // ─────────────────────────────────────────────────────────────────────
    public function updateStatus($id)
    {
        $trx = $this->transactionModel->find($id);

        if (! $trx) {
            return redirect()->to(site_url('admin/pesanan'))
                ->with('failed', 'Transaksi tidak ditemukan.');
        }

        $newStatus = min((int) $trx['status'] + 1, 2);
        $this->transactionModel->update($id, ['status' => $newStatus]);

        $statusLabel = match ($newStatus) {
            1 => 'Sedang Diproses',
            2 => 'Selesai',
            default => 'Pending',
        };

        // Redirect ke halaman asal (pesanan atau dashboard)
        $referer = $this->request->getServer('HTTP_REFERER') ?? site_url('admin/dashboard');
        $target  = str_contains($referer, 'pesanan') ? site_url('admin/pesanan') : site_url('admin/dashboard');

        return redirect()->to($target)
            ->with('success', 'Status #TRX-' . str_pad($id, 4, '0', STR_PAD_LEFT) . ' → ' . $statusLabel);
    }

    // ─────────────────────────────────────────────────────────────────────
    // HELPER: Statistik metode pembayaran
    // ─────────────────────────────────────────────────────────────────────
    private function getMetodeStat(): array
    {
        return Database::connect()
            ->table('transaction')
            ->select('metode_pembayaran as metode, COUNT(*) as jumlah, SUM(total_harga) as total')
            ->groupBy('metode_pembayaran')
            ->orderBy('jumlah', 'DESC')
            ->get()
            ->getResultArray();
    }
}
