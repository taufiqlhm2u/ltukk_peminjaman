<x-sidebar title="Kategori">
    <div class="flex justify-between gap-3 flex-wrap mb-3">
        <flux:heading size="xl">Data Kategori</flux:heading>
        <flux:button :href="route('admin.category.create')" variant="primary" color="blue" icon="plus">Tambah</flux:button>
    </div>
    <flux:separator />
    @livewire('livewire.category.table')
</x-sidebar>