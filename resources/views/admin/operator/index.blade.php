<x-sidebar title="Petugas">
    <div class="flex justify-between items-center gap-2 flex-wrap mb-3">
        <flux:heading size="xl">Daftar Petugas</flux:heading>
        <flux:button :href="route('admin.operator.create')" icon="plus" variant="primary" color="blue">Tambah
        </flux:button>
    </div>
    <flux:separator />

    @livewire('livewire.operator.table')
</x-sidebar>
