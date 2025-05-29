<?php

namespace App\Livewire\Pegawai;

use App\Models\Pegawai;
use App\Models\UnitKerja;
use Livewire\Attributes\Validate;
use Livewire\Component;


class EditPegawai extends Component
{
    #[Validate('required|string|max:20')]
    public $nip = '';

    #[Validate('required|string|max:100')]
    public $nama = '';

    #[Validate('required|exists:unit_kerjas,id')]
    public $unit_kerja_id = '';

    #[Validate('required|string|max:50')]
    public $jabatan = '';

    public Pegawai $pegawai;

    public function mount(Pegawai $pegawai)
    {
        $this->pegawai = $pegawai;
        $this->nip = $pegawai->nip;
        $this->nama = $pegawai->nama;
        $this->unit_kerja_id = $pegawai->unit_kerja_id;
        $this->jabatan = $pegawai->jabatan;
    }

    public function save()
    {
        $this->validate();

        $this->pegawai->update([
            'nip' => $this->nip,
            'nama' => $this->nama,
            'unit_kerja_id' => $this->unit_kerja_id,
            'jabatan' => $this->jabatan,
        ]);

        session()->flash('message', 'Data pegawai berhasil diperbarui.');
        return redirect()->route('pegawai.index');
    }

    public function render()
    {
        return view('livewire.pegawai.edit-pegawai', [
            'unitKerjas' => UnitKerja::all(),
        ]);
    }
}
