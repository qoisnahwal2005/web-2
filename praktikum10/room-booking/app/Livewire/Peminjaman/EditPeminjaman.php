<?php

namespace App\Livewire\Peminjaman;

use App\Models\Peminjaman;
use App\Models\Pegawai;
use App\Models\Ruang;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditPeminjaman extends Component
{
    public $pegawai_id, $ruang_id, $tanggal, $jam_mulai, $jam_akhir, $keperluan;
    public Peminjaman $peminjaman;

    public function mount(Peminjaman $peminjaman)
    {
        $this->peminjaman = $peminjaman;
        $this->pegawai_id = $peminjaman->pegawai_id;
        $this->ruang_id = $peminjaman->ruang_id;
        $this->tanggal = $peminjaman->tanggal;
        $this->jam_mulai = $peminjaman->jam_mulai;
        $this->jam_akhir = $peminjaman->jam_akhir;
        $this->keperluan = $peminjaman->keperluan;
    }

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

        $this->peminjaman->update([
            'pegawai_id' => $this->pegawai_id,
            'ruang_id' => $this->ruang_id,
            'tanggal' => $this->tanggal,
            'jam_mulai' => $this->jam_mulai,
            'jam_akhir' => $this->jam_akhir,
            'keperluan' => $this->keperluan,
        ]);

        session()->flash('message', 'Peminjaman berhasil diperbarui.');
        return redirect()->route('peminjaman.index');
    }

    public function render()
    {
        return view('livewire.peminjaman.edit-peminjaman', [
            'pegawais' => Pegawai::all(),
            'ruangs' => Ruang::all(),
        ]);
    }
}