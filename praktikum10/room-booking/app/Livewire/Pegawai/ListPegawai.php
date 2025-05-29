<?php

namespace App\Livewire\Pegawai;

use App\Models\Pegawai;
use App\Models\UnitKerja;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ListPegawai extends Component
{
    public function delete($id)
    {
        Pegawai::find($id)?->delete();
        session()->flash('message', 'Pegawai berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.pegawai.list-pegawai', [
            'pegawais' => Pegawai::with('unitKerja')->get()
        ]);
    }
}
