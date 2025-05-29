<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Edit Pegawai</h1>

    <form wire:submit.prevent="save" class="space-y-4">
        <!-- NIP -->
        <input type="text" wire:model.defer="nip" placeholder="NIP"
               class="border p-2 w-full" required />

        <!-- Nama -->
        <input type="text" wire:model.defer="nama" placeholder="Nama Pegawai"
               class="border p-2 w-full" required />

        <!-- Unit Kerja -->
        <select wire:model.defer="unit_kerja_id" class="border p-2 w-full" required>
            <option value="">-- Pilih Unit Kerja --</option>
            @foreach ($unitKerjas as $unit)
                <option value="{{ $unit->id }}">{{ $unit->nama }}</option>
            @endforeach
        </select>

        <!-- Tombol Update -->
        <button type="submit" class="bg-blue-500 px-4 py-2 text-white rounded">Update</button>
    </form>
</div>
