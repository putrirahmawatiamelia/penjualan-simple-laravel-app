<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as ModelUser;

class User extends Component
{
    public $pilihanMenu = 'lihat';
    public $nama;
    public $email;
    public $password;
    public $role;
    public $pilihPengguna;

    public function mount(){
        if(auth()->user()->role != 'admin'){
            abort(403);
        }
    }

    public function pilihUbah($id){
        $this->pilihPengguna = ModelUser::findOrFail($id);
        $this->nama = $this->pilihPengguna->name;
        $this->email = $this->pilihPengguna->email;
        $this->password = $this->pilihPengguna->password;
        $this->role = $this->pilihPengguna->role;
        $this->pilihanMenu = 'ubah';
    }

    public function simpanUbah(){
        $this->validate([
            'nama' => 'required',
            'email' => ['required', 'email', 'unique:users,email,' . $this->pilihPengguna->id],
            'password' => 'required',
            'role' => 'required'
        ],[
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'harus berformat email',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password harus diisi',
            'role.required' => 'Role harus diisi'
        ]);
        $simpan = $this->pilihPengguna;
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        if($this->password){
            $simpan->password = bcrypt($this->password);
        }
        $simpan->role = $this->role;
        $simpan->save();

        $this->reset('nama', 'email', 'password', 'role', 'pilihPengguna');
        $this->pilihanMenu = 'lihat';
    }

    public function pilihHapus($id){
        $this->pilihPengguna = ModelUser::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }

    public function hapus(){
        $this->pilihPengguna->delete();
        $this->reset();
    }

    public function batal(){
        $this->reset();
    }

    public function simpan(){
        $this->validate([
            'nama' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => 'required',
            'role' => 'required'
        ],[
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'harus berformat email',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password harus diisi',
            'role.required' => 'Role harus diisi'
        ]);
        $simpan = new ModelUser();
        $simpan->name = $this->nama;
        $simpan->email = $this->email;
        $simpan->password = bcrypt($this->password);
        $simpan->role = $this->role;
        $simpan->save();

        $this->reset('nama', 'email', 'password', 'role');
        $this->pilihanMenu = 'lihat';
    }

    public function pilihMenu($menu) {
        $this->pilihanMenu = $menu;
    }

    public function render()
    {
        return view('livewire.user')->with([
            'dataPengguna' => ModelUser::all()
        ]);
    }
}
