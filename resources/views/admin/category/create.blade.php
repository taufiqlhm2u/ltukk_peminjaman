<x-sidebar title="Tambah kategori">
    <div class="flex justify-between items-center gap-2 flex-wrap mb-3">
        <flux:heading size="xl">Tambah Kategori</flux:heading>
        <flux:button :href="route('admin.category.index')" icon="arrow-left" variant="outline">Kembali
        </flux:button>
    </div>
    <flux:separator />

    @livewire('livewire.category.create')
</x-sidebar>