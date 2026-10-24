<?php

use Livewire\Component;
use App\Models\Equipment;
use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDir = 'desc';

    // filter
    public $category_id = '';

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir == 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }

        $this->resetPage();
    }

    #[Computed]
    public function equipments()
    {
        return Equipment::when($this->search, function ($q) {
            $q->where(function ($query) {
                $query
                    ->where('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('stock', 'LIKE', '%' . $this->search . '%');
            });
        })->when(filled($this->category_id), function ($query) {
            $query->where('category_id', $this->category_id);
        })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate();
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
        <div class="flex justify-end gap-3 mb-3">
            <flux:input icon="magnifying-glass" type="search" wire:model.live.debounce.500ms="search"
                placeholder="Cari nama atau stok..." class="w-80!" autocomplete="off" />

            <flux:modal.trigger name="modal-filter">
                <flux:button variant="outline">Filter</flux:button>
            </flux:modal.trigger>
        </div>

        <flux:table :paginate="$this->equipments">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDir" wire:click="sort('name')">Gambar</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDir" wire:click="sort('name')">Nama
                </flux:table.column>
                <flux:table.column>Kategori
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'stock'" :direction="$sortDir" wire:click="sort('stock')">Stok Asli
                </flux:table.column>
                <flux:table.column>Tersedia
                </flux:table.column>
                <flux:table.column>Aksi</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @forelse ($this->equipments as $index => $row)
                <flux:table.row class="justify-center">
                    <flux:table.cell>{{ $this->equipment->firstItem() + $index }}</flux:table.cell>
                    <flux:table.cell class="">
                        <img src="{{ asset('storage/' . $row->image) }}" class="w-100 rounded" alt="">
                    </flux:table.cell>
                    <flux:table.cell class="text-zinc-800">{{ $row->name }}</flux:table.cell>
                    <flux:table.cell class="text-zinc-800">{{ $row->category->name }}</flux:table.cell>
                    <flux:table.cell class="text-zinc-800">{{ $row->stock }}</flux:table.cell>
                    <flux:table.cell class="text-zinc-800">{{ $row->available() }}</flux:table.cell>
                    <flux:table.cell>
                        <div class="flex gap-3">
                            <flux:button varaint="primary" icon="pencil-square"
                                :href="route('admin.equipment.edit', $row->id)" color="blue" size="sm" />

                            <flux:modal.trigger name="hapus-{{ $row->id }}">
                                <flux:button variant="danger" icon="trash" size="sm" />
                            </flux:modal.trigger>
                        </div>
                    </flux:table.cell>
                </flux:table.row>

                <flux:modal name="hapus-{{ $row->id }}" class="w-100!">
                    <div class="space-y-6">
                        <div class="mb-2 p-2">
                            <flux:heading size="xl">Konfirmasi Hapus</flux:heading>
                            <flux:text>Apakah kamu yakin ingin menghapus alat ini?
                                data alat dan data terkait tidak dapat dikembalikan setelah dihapus
                            </flux:text>
                        </div>
                        <form action="{{ route('admin.equipment.destroy', $row->id) }}" method="post"
                            class="w-full flex justify-end gap-3">
                            @csrf
                            @method('delete')
                            <flux:modal.close>
                                <flux:button variant="ghost" size="sm">Batal</flux:button>
                            </flux:modal.close>
                            <flux:button variant="danger" size="sm" type="submit">Ya, Hapus</flux:button>
                        </form>
                    </div>
                </flux:modal>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="7" class="text-center">
                        <p class="mt-5!">Tidak ada data yang ditemukan.</p>
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal name="modal-filter" class="w-100!">
        <div class="space-y-6">
            <flux:heading>Filter data</flux:heading>
            <flux:separator class="mt-3! mb-3!" />

            <flux:select wire:model="category_id" label="Kategori">
                <flux:select.option value="">Semua</flux:select.option>
                @foreach ($this->categories as $c)
                <flux:select.option value="{{ $c->id }}">{{ $c->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
    </flux:modal>
</div>