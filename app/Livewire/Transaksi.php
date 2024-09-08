<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi as ModelTransaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;

class Transaksi extends Component
{
    public $kode, $total, $kembalian, $totalSemuaBelanja;
    public $bayar = 0;
    public $transaksiAktif;

    public function transaksiBaru(){
        $this->reset();
        $this->transaksiAktif = new ModelTransaksi();
        $this->transaksiAktif->kode = 'INV/' . date('YmdHis');
        $this->transaksiAktif->total = 0;
        $this->transaksiAktif->status = 'pending';
        $this->transaksiAktif->save();
    }

    public function hapusProduk($id){
        $detail = DetailTransaksi::find($id);
        if($detail) {
            $produk = Produk::find($detail->produk_id);
            $produk->stok += $detail->jumlah;
            $produk->save();
        }
        $detail->delete();
    }

    public function batalTransaksi(){
        if($this->transaksiAktif){
            $detailTransaksi = DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id)->get();
            foreach ($detailTransaksi as $detail){
                $detail->delete();
            }
            $this->transaksiAktif->delete();
        }
        $this->reset();
    }

    public function updatedKode(){
        $produk = Produk::where('kode', $this->kode)->first();
        if($produk && $produk->stok > 0){
            $detail = DetailTransaksi::firstOrNew([
                'transaksi_id' => $this->transaksiAktif->id,
                'produk_id' => $produk->id,
            ], [
                'jumlah' => 0,
            ]);
            $detail->jumlah += 1;
            $detail->save();
            $produk->stok -= 1;
            $produk->save();
            $this->reset('kode');
        }
    }

    public function updatedBayar(){
        if($this->bayar > 0) {
            $this->kembalian = $this->bayar - $this->totalSemuaBelanja;
        }

    }

    public function transaksiPembayaran(){
        $this->transaksiAktif->total = $this->totalSemuaBelanja;
        $this->transaksiAktif->status = 'selesai';
        $this->transaksiAktif->save();
        $this->reset();
    }

    public function render()
    {
        $tampilProduk = Produk::where('stok', '>', 0)->get();  // Mengambil data barang dengan stok > 0

        if($this->transaksiAktif){
            $semuaProduk = DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id)->get();
            $this->totalSemuaBelanja = $semuaProduk->sum(function ($detail){
                return $detail->produk->harga * $detail->jumlah;
            });
        } else {
            $semuaProduk = [];
        }
        return view('livewire.transaksi')->with([
            'semuaProduk' => $semuaProduk,
            'tampilProduk' => $tampilProduk
        ]);
    }
}
