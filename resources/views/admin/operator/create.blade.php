<x-sidebar title="Petugas">
    <div class="flex justify-between items-center gap-2 flex-wrap mb-3">
        <flux:heading size="xl">Tambah Petugas</flux:heading>
        <flux:button :href="route('admin.operator.index')" icon="arrow-left" variant="outline">Kembali
        </flux:button>
    </div>
    <flux:separator />

    @livewire('livewire.operator.create')
</x-sidebar>