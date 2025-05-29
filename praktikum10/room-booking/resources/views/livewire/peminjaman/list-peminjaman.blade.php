<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Daftar Peminjaman</h1>

    @if (session('message'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('peminjaman.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Peminjaman</a>
    </div>

    <table class="w-full border-collapse border border-gray-400">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border">Pegawai</th>
                <th class="py-2 px-4 border">Ruang</th>
                <th class="py-2 px-4 border">Tanggal</th>
                <th class="py-2 px-4 border">Jam</th>
                <th class="py-2 px-4 border">Keperluan</th>
                <th class="py-2 px-4 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjamans as $p)
                <tr>
                    <td class="py-2 px-4 border">{{ $p->pegawai->nama ?? '-' }}</td>
                    <td class="py-2 px-4 border">{{ $p->ruang->nama ?? '-' }}</td>
                    <td class="py-2 px-4 border">{{ $p->tanggal }}</td>
                    <td class="py-2 px-4 border">{{ $p->jam_mulai }} - {{ $p->jam_akhir }}</td>
                    <td class="py-2 px-4 border">{{ $p->keperluan }}</td>
                    <td class="py-2 px-4 border">
                        <a href="{{ route('peminjaman.edit', $p->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <button wire:click="delete({{ $p->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
