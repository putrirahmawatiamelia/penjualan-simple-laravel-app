<div>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-2">
                @if (!$transaksiAktif)
                <button class="btn btn-primary" wire:click='transaksiBaru'>Transaksi Baru</button>
                @else
                <button class="btn btn-danger" wire:click='batalTransaksi'>Batal Transaksi</button>
                @endif
                <button class="btn btn-secondary" wire:loading>Loading...</button>
            </div>
        </div>
        @if ($transaksiAktif)
        <div class="row mt-2">
            <div class="col-8">
                <div class="card border-dark">
                    <div class="card-body">
                        <h4 class="card-title">No Invoice: {{ $transaksiAktif->kode }}</h4>
                        <input type="text" placeholder="Masukkan Kode Barang" class="form-control" wire:model.live='kode'>
                        <select class="form-control mt-1" wire:model.live='kode'>
                            <option value="">Pilih Barang</option>
                            @foreach ($tampilProduk as $tproduk)
                                <option value="{{ $tproduk->kode }}">{{ $tproduk->kode }} - {{ $tproduk->nama }}</option>
                            @endforeach
                        </select>
                        <table class="table table-bordered mt-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($semuaProduk as $produk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $produk->produk->kode }}</td>
                                        <td>{{ $produk->produk->nama }}</td>
                                        <td>{{ number_format($produk->produk->harga, 2, '.', ',') }}</td>
                                        <td>
                                            {{ $produk->jumlah }}
                                        </td>
                                        <td>{{ number_format($produk->produk->harga * $produk->jumlah, 2, '.', ',') }}</td>
                                        <td>
                                            <button class="btn btn-danger" wire:click='hapusProduk({{ $produk->id }})'>Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card border-dark">
                    <div class="card-body">
                        <h4 class="card-title">Total Biaya</h4>
                        <div class="d-flex justify-content-between">
                            <span>Rp.</span>
                            <span>{{ number_format($totalSemuaBelanja, 2, '.', ',') }}</span>
                        </div>
                    </div>
                </div>
                <div class="card border-dark mt-2">
                    <div class="card-body">
                        <h4 class="card-title">Bayar</h4>
                        <div class="d-flex justify-content-between">
                            <input type="number" name="bayar" class="form-control" placeholder="0" wire:model.live='bayar'>
                        </div>
                    </div>
                </div>
                <div class="card border-dark mt-2">
                    <div class="card-body">
                        <h4 class="card-title">Kembalian</h4>
                        <div class="d-flex justify-content-between">
                            <span>Rp.</span>
                            <span>{{ number_format($kembalian, 2, '.', ',') }}</span>
                        </div>
                    </div>
                </div>
                @if ($bayar)
                    @if ($kembalian < 0)
                        <div class="alert alert-danger mt-2" role="alert">
                            Uang Kurang
                        </div>
                        <button class="btn btn-success w-100" disabled>Bayar</button>
                    @elseif ($kembalian >= 0)
                        <button class="btn btn-success mt-2 w-100" wire:click='transaksiPembayaran'>Bayar</button>
                    @endif
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
