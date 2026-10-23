<x-sidebar title="Edit Kategori">
    <div class="flex justify-between items-center gap-2 flex-wrap mb-3">
        <flux:heading size="xl">Edit Kategori</flux:heading>
        <flux:button :href="route('admin.category.index')" icon="arrow-left" variant="outline">Kembali
        </flux:button>
    </div>
    <flux:separator />

    @livewire('livewire.category.edit', ['kategori' => $kategori])
</x-sidebar>