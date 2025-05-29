<?php

namespace App\Livewire\Peminjaman;

use App\Models\Peminjaman;
use App\Models\Pegawai;
use App\Models\Ruang;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreatePeminjaman extends Component
{
    public $pegawai_id, $ruang_id, $tanggal, $jam_mulai, $jam_akhir, $keperluan;

    public function save()
    {
        $this->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'ruang_id' => 'required|exists:ruangs,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_akhir' => 'required|after:jam_mulai',
            'keperluan' => 'required|string|max:255',
        ]);

        Peminjaman::create([
            'pegawai_id' => $this->pegawai_id,
            'ruang_id' => $this->ruang_id,
            'tanggal' => $this->tanggal,
            'jam_mulai' => $this->jam_mulai,
            'jam_akhir' => $this->jam_akhir,
            'keperluan' => $this->keperluan,
        ]);

        session()->flash('message', 'Peminjaman berhasil ditambahkan.');
        return redirect()->route('peminjaman.index');
    }

    public function render()
    {
        return view('livewire.peminjaman.create-peminjaman', [
            'pegawais' => Pegawai::all(),
            'ruangs' => Ruang::all(),
        ]);
    }
}
