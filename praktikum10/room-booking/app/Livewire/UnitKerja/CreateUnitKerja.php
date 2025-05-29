<?php

namespace App\Livewire\UnitKerja;

use App\Models\UnitKerja;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateUnitKerja extends Component
{
    public $nama = '';

    public function save()
    {
        $this->validate([
            'nama' => 'required|string|max:100',
        ]);

        UnitKerja::create(['nama' => $this->nama]);

        session()->flash('message', 'Unit Kerja berhasil ditambahkan.');
        return redirect('/unit-kerja');
    }

    public function render()
    {
        return view('livewire.unit-kerja.create-unit-kerja');
    }
}