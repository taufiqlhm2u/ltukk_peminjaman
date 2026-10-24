<?php

use Livewire\Component;
use App\Models\Category;
use App\Models\Equipment;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;

new class extends Component {
    use WithFileUploads;

    public $nama = '';
    public $kategori = '';
    public $stok = '';
    public $gambar = '';
    public $kondisi_barang = '';

    public function rules(): array
    {
        return [
            'nama' => 'required|string|unique:equipments,name',
            'kategori' => 'required|exists:categories,id',
            'stok' => 'required|integer',
            'gambar' => 'required|image|mimes:jpg,png,webp,jpeg|max:2048',
            'kondisi_barang' => 'required|string|max:300',
        ];
    }

    public function store()
    {
        $this->validate();
        try {
            $imagePath = $this->gambar->store('equipments', 'public');

            Equipment::create([
                'category_id' => $this->category_id,
                'name' => $this->nama,
                'stock' => $this->stok,
                'gambar' => $imagePath,
                'condition_status' => $this->kondisi_barang,
            ]);

            return redirect()->route('admin.crew.index')->with('success', 'Data kru berhasil dtambahkan.');
        } catch (\Exception) {
            $this->dispatch('alert', type: 'error', message: 'Terjadi kesalahan saat menambahkan data kru.');
        }
    }

    #[Computed]
    public function categories()
    {
        return Category::orderBy('name', 'asc')->get();
    }
};
?>

<div class="mt-5">
    <flux:card class="p-5">
        <form wire:submit="store" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:input placeholder="masukan nama alat" label="Nama Alat" wire:model="nama" />
                </div>

               <div>
                <flux:select wire:model.live="kategori" label="kategori">
                    <flux:select.option value="">Pilih</flux:select.option>
                    @foreach ($this->categories as $c)
                    <flux:select.option value="{{ $c->id }}">{{ $c->name }}</flux:select.option>
                    @endforeach
                </flux:select>
               </div>

                <div>
                    <flux:input label="Gambar" type="file" accept="image/png,image/jpg,image/webp,image/jpeg" wire:model="gambar" />
                </div>

                <div>
                    <flux:input placeholder="00" label="Stok" type="number" min="1" wire:model="stok" />
                </div>

                <div class="col-span-2">
                    <flux:textarea label="Kondisi barang" wire:model="kondisi_barang" placeholder="Masukan kondisi barang yang ada"></flux:textarea>
                </div>

            </div>
            <div class="flex justify-end gap-4 items-center mt-3">
                <flux:button variant="ghost" :href="route('admin.equipment.index')">Batal</flux:button>
                <flux:button variant="primary" color="blue" type="submit">Tambah</flux:button>
            </div>
        </form>
    </flux:card>
</div>