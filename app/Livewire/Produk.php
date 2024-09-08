<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produk as ModelProduk;
use App\Models\User;

class Produk extends Component
{
    public $pilihanMenu = 'lihat';
    public $kode;
    public $nama;
    public $harga;
    public $stok;
    public $kategori;
    public $pilihProduk;
    public $search = '';

    public function mount(){
        if(auth()->user()->role != 'admin'){
            abort(403);
        }
    }

    public function pilihUbah($id){
        $this->pilihProduk = ModelProduk::findOrFail($id);
        $this->kode = $this->pilihProduk->kode;
        $this->nama = $this->pilihProduk->nama;
        $this->harga = $this->pilihProduk->harga;
        $this->stok = $this->pilihProduk->stok;
        $this->kategori = $this->pilihProduk->kategori;
        $this->pilihanMenu = 'ubah';
    }

    public function simpanUbah(){
        $this->validate([
            'kode' => ['required','unique:produks,kode,' . $this->pilihProduk->id],
            'nama' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'kategori' => 'required'
        ],[
            'kode.required' => 'Kode harus diisi',
            'kode.unique' => 'Kode telah digunakan',
            'nama.required' => 'Nama harus diisi',
            'harga.required' => 'Harga harus diisi',
            'stok.required' => 'Stok harus diisi',
            'kategori.required' => 'Kategori harus diisi'
        ]);
        $simpan = $this->pilihProduk;
        $simpan->nama = $this->nama;
        $simpan->harga = $this->harga;
        $simpan->stok = $this->stok;
        $simpan->kategori = $this->kategori;
        $simpan->save();

        $this->reset('kode', 'nama', 'harga', 'stok', 'kategori', 'pilihProduk');
        $this->pilihanMenu = 'lihat';
    }

    public function pilihHapus($id){
        $this->pilihProduk = ModelProduk::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }

    public function hapus(){
        $this->pilihProduk->delete();
        $this->reset();
    }

    public function batal(){
        $this->reset();
    }

    public function simpan(){
        $this->validate([
            'kode' => ['required','unique:produks,kode'],
            'nama' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'kategori' => 'required'
        ],[
            'kode.required' => 'Kode harus diisi',
            'kode.unique' => 'Kode telah digunakan',
            'nama.required' => 'Nama harus diisi',
            'harga.required' => 'Harga harus diisi',
            'stok.required' => 'Stok harus diisi',
            'kategori.required' => 'Kategori harus diisi'
        ]);
        $simpan = new ModelProduk();
        $simpan->kode = $this->kode;
        $simpan->nama = $this->nama;
        $simpan->harga = $this->harga;
        $simpan->stok = $this->stok;
        $simpan->kategori = $this->kategori;
        $simpan->save();

        $this->reset('kode', 'nama', 'harga', 'stok', 'kategori');
        $this->pilihanMenu = 'lihat';
    }

    public function pilihMenu($menu) {
        $this->pilihanMenu = $menu;
    }
    public function render()
    {
        // Mengambil data produk dengan pencarian
        $products = ModelProduk::where('nama', 'like', '%' . $this->search . '%')->get();

        return view('livewire.produk')->with([
            'dataProduk' => ModelProduk::all(),
            'products' => $products
        ]);
    }
}
