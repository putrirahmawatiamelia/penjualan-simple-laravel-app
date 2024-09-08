<div>
    <div class="container">
        <div class="row mt-3">
            <div class="col-12">
                <div class="card border-dark">
                    <div class="card-body">
                        <h4 class="card-title">Laporan Transaksi Penjualan</h4>
                        <a href="{{ url('/cetak') }}" class="btn btn-primary" target="_blank">Cetak</a>
                        <input type="date" wire:model="start_date" placeholder="Start Date">
                        <input type="date" wire:model="end_date" placeholder="End Date">
                        <button wire:click="searchByDateRange">Cari</button>
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Tanggal Transaksi</th>
                                <th>No. Invoice</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($semuaTransaksi as $transaksi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaksi->created_at }}</td>
                                        <td>{{ $transaksi->kode }}</td>
                                        <td>Rp. {{ number_format($transaksi->total, '2', '.', ',') }}</td>
                                        <td>
                                            <button class="btn btn-success" wire:click='tampilDetailTransaksi'>Lihat Detail Transaksi</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
