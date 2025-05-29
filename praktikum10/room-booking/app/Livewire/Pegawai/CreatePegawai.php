<?php

namespace App\Livewire\Pegawai;

use App\Models\Pegawai;
use App\Models\UnitKerja;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreatePegawai extends Component
{
    #[Validate('required|string|max:20')]
    public $nip = '';

    #[Validate('required|string|max:100')]
    public $nama = '';

    #[Validate('required|exists:unit_kerjas,id')]
    public $unit_kerja_id = '';

    #[Validate('required|string|max:50')]
    public $jabatan = '';

    public function save()
    {
        $this->validate();

        Pegawai::create([
            'nip' => $this->nip,
            'nama' => $this->nama,
            'unit_kerja_id' => $this->unit_kerja_id,
            'jabatan' => $this->jabatan,
        ]);

        session()->flash('message', 'Pegawai berhasil ditambahkan.');
        return redirect()->route('pegawai.index');
    }

    public function render()
    {
        return view('livewire.pegawai.create-pegawai', [
            'unitKerjas' => \App\Models\UnitKerja::all(), // <-- HARUS ini
            ]);
    }
}
