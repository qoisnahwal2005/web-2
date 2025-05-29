<?php

namespace App\Livewire\Peminjaman;

use App\Models\Peminjaman;
use App\Models\Pegawai;
use App\Models\Ruang;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ListPeminjaman extends Component
{
    public function delete($id)
    {
        Peminjaman::find($id)?->delete();
        session()->flash('message', 'Peminjaman berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.peminjaman.list-peminjaman', [
            'peminjamans' => Peminjaman::with(['pegawai', 'ruang'])->get()
        ]);
    }
}
