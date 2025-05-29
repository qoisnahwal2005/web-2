<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Tambah Peminjaman</h1>

    <form wire:submit.prevent="save" class="space-y-4">
        <select wire:model.defer="pegawai_id" class="border p-2 w-full" required>
            <option value="">-- Pilih Pegawai --</option>
            @foreach ($pegawais as $pegawai)
                <option value="{{ $pegawai->id }}">{{ $pegawai->nama }}</option>
            @endforeach
        </select>

        <select wire:model.defer="ruang_id" class="border p-2 w-full" required>
            <option value="">-- Pilih Ruangan --</option>
            @foreach ($ruangs as $ruang)
                <option value="{{ $ruang->id }}">{{ $ruang->nama }}</option>
            @endforeach
        </select>

        <input type="date" wire:model.defer="tanggal" class="border p-2 w-full" required />
        <input type="time" wire:model.defer="jam_mulai" class="border p-2 w-full" required />
        <input type="time" wire:model.defer="jam_akhir" class="border p-2 w-full" required />
        <textarea wire:model.defer="keperluan" placeholder="Keperluan" class="border p-2 w-full" required></textarea>

        <button type="submit" class="bg-blue-500 px-4 py-2 text-white rounded">Simpan</button>
    </form>
</div>
