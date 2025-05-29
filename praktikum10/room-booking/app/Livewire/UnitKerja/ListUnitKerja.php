<?php

namespace App\Livewire\UnitKerja;

use Livewire\Component;
use App\Models\UnitKerja;

class ListUnitKerja extends Component
{
    public function render()
    {
        return view('livewire.unit-kerja.list-unit-kerja', [
            'unitkerjas' => UnitKerja::all(),
        ]);
    }

    public function delete($id)
    {
        $unitkerja = UnitKerja::find($id);

        if ($unitkerja) {
            $unitkerja->delete();
            session()->flash('message', 'Unit Kerja berhasil dihapus.');
        } else {
            session()->flash('error', 'Unit Kerja tidak ditemukan.');
        }
    }
}