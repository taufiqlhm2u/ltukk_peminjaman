<?php

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Models\User;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $sortBy = 'created_at';
    public $sortDir = 'desc';

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }

        $this->resetPage();
    }

    #[Computed]
    public function operators()
    {
        return User::where('role', 'operator')
            ->when(filled($this->search), function ($q) {
                $q->where(function ($query) {
                    $query->where('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('telpon', 'LIKE', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate();
    }
};
?>



<div class="mt-5">
    <flux:card class="p-5">
        <div class="flex justify-end mb-4">
            <flux:input icon="magnifying-glass" wire:model.live.debounce.500ms="search"
                placeholder="Cari nama, email atau telepon..." class="w-80!" autocomplete="off" />
        </div>
        <flux:table :paginate="$this->operators">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDir" wire:click="sort('name')">Nama</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'email'" :direction="$sortDir" wire:click="sort('email')">Email</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'telpon'" :direction="$sortDir" wire:click="sort('telpon')">Telepon</flux:table.column>
                <flux:table.column>Aksi</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @forelse ($this->operators as $index => $row)
                    <flux:table.row class="justify-center">
                        <flux:table.cell>{{ $this->operators->firstItem() + $index }}</flux:table.cell>
                        <flux:table.cell class="text-zinc-800">{{ $row->name }}</flux:table.cell>
                        <flux:table.cell class="text-zinc-800">{{ $row->email }}</flux:table.cell>
                        <flux:table.cell class="text-zinc-800">{{ $row->telpon }}</flux:table.cell>
                        <flux:table.cell class="justfy-center">
                            <div class="flex gap-3 items-center">
                                <flux:button icon="pencil-square" variant="primary" size="sm" color="blue" :href="route('admin.operator.edit', $row->id)" />
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
                                <flux:text>Apakah kamu yakin ingin menghapus petugas ini?
                                    data petugas dan data terkait tidak dapat dikembalikan setelah dihapus
                                </flux:text>
                            </div>
                            <form action="{{ route('admin.operator.destroy', $row->id) }}" method="post" class="w-full flex justify-end gap-3">
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
                    <flux:table.row >
                        <flux:table.cell colspan="5" class="text-center">
                            <p class="mt-5!">Tidak ada data yang ditemukan.</p></flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
