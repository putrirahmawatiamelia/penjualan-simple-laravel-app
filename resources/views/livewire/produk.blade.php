<div>

    <div class="container">
        <div class="row my-2">
            <div class="col-12">
                <button wire:click="pilihMenu('lihat')" class="btn {{ $pilihanMenu=='lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Data Produk
                </button>
                <button wire:click="pilihMenu('tambah')" class="btn {{ $pilihanMenu=='tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Tambah Produk
                </button>
                <button wire:loading class="btn btn-secondary">
                    Loading...
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if ($pilihanMenu=='lihat')
                <div class="card border-dark">
                    <div class="card-header">
                        Data Produk
                    </div>
                    <!-- Input Pencarian -->
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Cari Nama Produk..." wire:model="search">
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($dataProduk as $produk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $produk->kode }}</td>
                                        <td>{{ $produk->nama }}</td>
                                        <td>{{ number_format($produk->harga, 0, ',', '.') }}</td>
                                        <td>{{ $produk->stok }}</td>
                                        <td>{{ $produk->kategori }}</td>
                                        <td>
                                            <button wire:click="pilihUbah({{ $produk->id }})" class="btn {{ $pilihanMenu=='ubah' ? 'btn-warning' : 'btn-outline-warning' }}">
                                                Ubah
                                            </button>
                                            <button wire:click="pilihHapus({{ $produk->id }})" class="btn {{ $pilihanMenu=='hapus' ? 'btn-danger' : 'btn-outline-danger' }}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @elseif ($pilihanMenu=='tambah')
                <div class="card border-primary">
                    <div class="card-header">
                        Tambah Produk
                    </div>
                    <div class="card-body">
                        <form wire:submit='simpan'>
                            <label for="Kode">Kode</label>
                            <input type="text" class="form-control" wire:model='kode'>
                            @error('kode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="Nama">Nama</label>
                            <input type="text" class="form-control" wire:model='nama'>
                            @error('nama')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" oninput="formatNumber(this)" wire:model='harga'>
                            @error('harga')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control" wire:model='stok'>
                            @error('stok')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="kategori">Kategori</label>
                            <input type="text" class="form-control" wire:model='kategori'>
                            @error('kategori')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        </form>
                    </div>
                </div>
                @elseif ($pilihanMenu=='ubah')
                <div class="card border-primary">
                    <div class="card-header">
                        Ubah Produk
                    </div>
                    <div class="card-body">
                        <form wire:submit='simpanUbah'>
                            <label for="Kode">Kode</label>
                            <input type="text" class="form-control" wire:model='kode' readonly>
                            @error('kode')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="Nama">Nama</label>
                            <input type="text" class="form-control" wire:model='nama'>
                            @error('nama')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" oninput="formatNumber(this)" wire:model='harga'>
                            @error('harga')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="Stok">Stok</label>
                            <input type="number" class="form-control" wire:model='stok'>
                            @error('stok')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="kategori">Kategori</label>
                            <input type="text" class="form-control" wire:model='kategori'>
                            @error('kategori')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                            <button type="button" wire:click='batal' class="btn btn-secondary mt-3">Batal</button>
                        </form>
                    </div>
                </div>
                @elseif ($pilihanMenu=='hapus')
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        Hapus Produk
                    </div>
                    <div class="card-body">
                        Anda yakin akan menghapus data ini?
                        <p>Kode: {{ $pilihProduk->kode }} <br/>
                        Nama: {{ $pilihProduk->nama }} <br/>
                        Harga: Rp.{{ $pilihProduk->harga }} <br/>
                        Stok: {{ $pilihProduk->stok }}  <br/>
                        Kategori: {{ $pilihProduk->kategori }}</p>
                        <button class="btn btn-danger" wire:click='hapus'>Hapus</button>
                        <button class="btn btn-secondary" wire:click='batal'>Batal</button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
<script>
    function formatNumber(input) {
        // Menghapus karakter non-digit
        let value = input.value.replace(/\D/g, '');

        // Menambahkan koma pada ribuan
        input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
</script>
