<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Edit Unit Kerja</h1>

    <form wire:submit.prevent="save" class="space-y-4">
        <input type="text" wire:model.defer="nama" placeholder="Nama Unit Kerja"
               class="border p-2 w-full" required />
        <input type="text" wire:model.defer="kode" placeholder="Kode Unit Kerja"
                class="border p-2 w-full" required />
        <button type="submit" class="bg-blue-500 px-4 py-2 text-white rounded">Simpan</button>
    </form>
</div>
