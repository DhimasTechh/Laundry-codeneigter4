<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class TransaksiController extends BaseController
{
    protected $cart;
    protected TransactionModel $transactionModel;
    protected TransactionDetailModel $transactionDetailModel;

    public function __construct()
    {
        helper(['number', 'form']);
        $this->cart                   = service('cart');
        $this->transactionModel       = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    /**
     * Halaman keranjang belanja.
     */
    public function index()
    {
        $data = [
            'items' => $this->cart->contents(),
            'total' => $this->cart->total(),
        ];

        return view('keranjang/index', $data);
    }

    /**
     * Tambah item ke keranjang (dari halaman katalog).
     */
    public function cart_add()
    {
        $this->cart->insert([
            'id'      => $this->request->getPost('id'),
            'qty'     => 1,
            'price'   => $this->request->getPost('harga'),
            'name'    => $this->request->getPost('nama'),
            'options' => [
                'foto' => $this->request->getPost('foto'),
            ],
        ]);

        session()->setFlashdata(
            'success',
            'Layanan berhasil ditambahkan ke keranjang. <a href="' . base_url('keranjang') . '">Lihat</a>'
        );

        return redirect()->to(base_url('/'));
    }

    /**
     * Perbarui jumlah item di keranjang.
     */
    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $item) {
            $qty = $this->request->getPost('qty' . $i++);

            $this->cart->update([
                'rowid' => $item['rowid'],
                'qty'   => $qty,
            ]);
        }

        session()->setFlashdata('success', 'Keranjang berhasil diperbarui');

        return redirect()->to(base_url('keranjang'));
    }

    /**
     * Hapus satu item dari keranjang.
     */
    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);

        session()->setFlashdata('success', 'Produk berhasil dihapus dari keranjang');

        return redirect()->to(base_url('keranjang'));
    }

    /**
     * Kosongkan seluruh keranjang.
     */
    public function cart_clear()
    {
        $this->cart->destroy();

        session()->setFlashdata('success', 'Keranjang berhasil dikosongkan');

        return redirect()->to(base_url('keranjang'));
    }

    /**
     * Halaman checkout — tampilkan ringkasan + form data pengiriman.
     */
    public function checkout()
    {
        $items = $this->cart->contents();

        if (empty($items)) {
            session()->setFlashdata('failed', 'Keranjang masih kosong. Tambah layanan terlebih dahulu.');
            return redirect()->to(base_url('keranjang'));
        }

        $ongkir = 10000; // Ongkir flat

        $data = [
            'items'  => $items,
            'total'  => $this->cart->total(),
            'ongkir' => $ongkir,
            'grand_total' => $this->cart->total() + $ongkir,
        ];

        return view('keranjang/checkout', $data);
    }

    /**
     * Proses checkout — simpan transaksi ke database.
     */
    public function processCheckout()
    {
        $items = $this->cart->contents();

        if (empty($items)) {
            return redirect()->to(base_url('keranjang'));
        }

        $ongkir  = 10000;
        $total   = $this->cart->total() + $ongkir;
        $username = session()->get('username');

        // Simpan transaksi utama
        $transactionId = $this->transactionModel->insert([
            'username'           => $username,
            'total_harga'        => $total,
            'alamat'             => $this->request->getPost('alamat'),
            'ongkir'             => $ongkir,
            'status'             => 0,  // 0 = Pending
            'metode_pembayaran'  => $this->request->getPost('metode_pembayaran'),
            'nama_penerima'      => $this->request->getPost('nama_penerima'),
            'telepon'            => $this->request->getPost('telepon'),
        ]);

        // Simpan detail tiap item
        foreach ($items as $item) {
            $this->transactionDetailModel->insert([
                'transaction_id' => $transactionId,
                'product_id'     => $item['id'],
                'jumlah'         => $item['qty'],
                'diskon'         => 0,
                'subtotal_harga' => $item['subtotal'],
            ]);
        }

        // Kosongkan keranjang setelah checkout
        $this->cart->destroy();

        session()->setFlashdata('checkout_success', [
            'transaction_id' => $transactionId,
            'total'          => $total,
            'metode'         => $this->request->getPost('metode_pembayaran'),
        ]);

        return redirect()->to(base_url('keranjang/checkout/success'));
    }

    /**
     * Halaman sukses setelah checkout.
     */
    public function checkoutSuccess()
    {
        $data = session()->getFlashdata('checkout_success');

        if (! $data) {
            return redirect()->to(base_url('/'));
        }

        return view('keranjang/checkout_success', ['data' => $data]);
    }

    /**
     * Riwayat pesanan milik user yang sedang login.
     */
    public function myOrders()
    {
        $username = session()->get('username');

        $transactions = $this->transactionModel->getByUsername($username);

        // Ambil detail untuk setiap transaksi
        foreach ($transactions as &$trx) {
            $trx['details'] = $this->transactionDetailModel->getDetailWithProduct($trx['id']);
        }
        unset($trx);

        return view('guest/my_orders', [
            'transactions' => $transactions,
        ]);
    }
}
