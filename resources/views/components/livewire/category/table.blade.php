<?php

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDir = 'desc';

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
    public function crews()
    {
        return Category::when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query
                        ->where('name', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate();
    }
};
?>

<div class="mt-5">
    <flux:card class="p-5">
        <div class="flex justify-end mb-3">
            <flux:input icon="magnifying-glass" type="search" wire:model.live.debounce.500ms="search"
                placeholder="Cari kategori..." class="w-80!" autocomplete="off" />
        </div>

        <flux:table :paginate="$this->crews">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDir" wire:click="sort('name')">Nama Kategori
                </flux:table.column>
                <flux:table.column>Aksi</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @forelse ($this->crews as $index => $row)
                    <flux:table.row class="justify-center">
                        <flux:table.cell>{{ $this->crews->firstItem() + $index }}</flux:table.cell>
                        <flux:table.cell class="text-zinc-800">{{ $row->name }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-3">
                                <flux:button varaint="primary" icon="pencil-square"
                                    :href="route('admin.category.edit', $row->id)" color="blue" size="sm" />

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
                                <flux:text>Apakah kamu yakin ingin menghapus kategori ini?
                                    data kategori beserta data terkait tidak dapat dikembalikan setelah dihapus
                                </flux:text>
                            </div>
                            <form action="{{ route('admin.category.destroy', $row->id) }}" method="post"
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
                        <flux:table.cell colspan="5" class="text-center">
                            <p class="mt-5!">Tidak ada data yang ditemukan.</p>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>