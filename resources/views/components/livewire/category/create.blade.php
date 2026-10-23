<?php

use Livewire\Component;
use App\Models\Category;

new class extends Component {
    public $nama_kategori = '';

    public function rules(): array
    {
        return [
            'nama_kategori' => 'required|string|unique:categories,name',
        ];
    }

    public function store()
    {
        $this->validate();
        try {
            Category::create([
                'name' => $this->nama_kategori
            ]);

            return redirect()->route('admin.category.index')->with('success', 'Data kategori berhasil dtambahkan.');
        } catch (\Exception) {
            $this->dispatch('alert', type: 'error', message: 'Terjadi kesalahan saat menambahkan data kategori.');
        }
    }
};
?>

<div class="mt-5">
    <flux:card class="p-5">
        <form wire:submit="store">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-2">
                    <flux:input placeholder="masukan nama kategori" label="Nama Kategori" wire:model="nama_kategori" />
                </div>

            </div>
            <div class="flex justify-end gap-4 items-center mt-3">
                <flux:button variant="ghost" :href="route('admin.category.index')">Batal</flux:button>
                <flux:button variant="primary" color="blue" type="submit">Tambah</flux:button>
            </div>
        </form>
    </flux:card>
</div>