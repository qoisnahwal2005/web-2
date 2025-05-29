<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Daftar Pegawai</h1>

    @if (session('message'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="/pegawai/create" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Pegawai</a>
    </div>

    <table class="w-full border-collapse border border-gray-400">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border">NIP</th>
                <th class="py-2 px-4 border">Nama</th>
                <th class="py-2 px-4 border">Unit Kerja</th>
                <th class="py-2 px-4 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pegawais as $pegawai)
                <tr>
                    <td class="py-2 px-4 border">{{ $pegawai->nip }}</td>
                    <td class="py-2 px-4 border">{{ $pegawai->nama }}</td>
                    <td class="py-2 px-4 border">{{ $pegawai->unitKerja->nama ?? '-' }}</td>
                    <td class="py-2 px-4 border">
                        <a href="/pegawai/edit/{{ $pegawai->id }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <button wire:click="delete({{ $pegawai->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
