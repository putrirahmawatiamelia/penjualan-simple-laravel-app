<div>

    <div class="container">
        <div class="row my-2">
            <div class="col-12">
                <button wire:click="pilihMenu('lihat')" class="btn {{ $pilihanMenu=='lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Data Pengguna
                </button>
                <button wire:click="pilihMenu('tambah')" class="btn {{ $pilihanMenu=='tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                    Tambah Pengguna
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
                        Data Pengguna
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>E-mail</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                @foreach ($dataPengguna as $pengguna)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pengguna->name }}</td>
                                        <td>{{ $pengguna->email }}</td>
                                        <td>{{ $pengguna->role }}</td>
                                        <td>
                                            <button wire:click="pilihUbah({{ $pengguna->id }})" class="btn {{ $pilihanMenu=='ubah' ? 'btn-warning' : 'btn-outline-warning' }}">
                                                Ubah
                                            </button>
                                            <button wire:click="pilihHapus({{ $pengguna->id }})" class="btn {{ $pilihanMenu=='hapus' ? 'btn-danger' : 'btn-outline-danger' }}">
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
                        Tambah Pengguna
                    </div>
                    <div class="card-body">
                        <form wire:submit='simpan'>
                            <label for="Nama">Nama</label>
                            <input type="text" class="form-control" wire:model='nama'>
                            @error('nama')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" wire:model='email'>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="Password">Password</label>
                            <input type="password" class="form-control" wire:model='password'>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="Role">Role</label>
                            <select name="" id="" class="form-control" wire:model='role'>
                                <option>--Pilih Role--</option>
                                <option value="kasir">Kasir</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role')
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
                        Ubah Pengguna
                    </div>
                    <div class="card-body">
                        <form wire:submit='simpanUbah'>
                            <label for="Nama">Nama</label>
                            <input type="text" class="form-control" wire:model='nama'>
                            @error('nama')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" wire:model='email'>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="Password">Password</label>
                            <input type="password" class="form-control" wire:model='password'>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <br/>
                            <label for="Role">Role</label>
                            <select name="" id="" class="form-control" wire:model='role'>
                                <option>--Pilih Role--</option>
                                <option value="kasir">Kasir</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role')
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
                        Hapus Pengguna
                    </div>
                    <div class="card-body">
                        Anda yakin akan menghapus data ini?
                        <p>Nama: {{ $pilihPengguna->name }}</p>
                        <button class="btn btn-danger" wire:click='hapus'>Hapus</button>
                        <button class="btn btn-secondary" wire:click='batal'>Batal</button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
