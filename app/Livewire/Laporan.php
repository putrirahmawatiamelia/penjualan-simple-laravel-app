<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;

class Laporan extends Component
{
    public $start_date;
    public $end_date;
    public $transactions;

    public function mount()
    {
        $this->transactions = Transaksi::all();
    }

    public function searchByDateRange()
    {
        $this->transactions = Transaksi::whereBetween('created_at', [$this->start_date, $this->end_date])
                                         ->get();
    }

    public $detail;
    public function tampilDetailTransaksi($id){
        $this->detail = DetailTransaksi::findOrFail($id);
    }

    public function render()
    {
        $semuaTransaksi = Transaksi::where('status', 'selesai')->get();
        return view('livewire.laporan')->with([
            'semuaTransaksi' => $semuaTransaksi
        ]);
    }
}
