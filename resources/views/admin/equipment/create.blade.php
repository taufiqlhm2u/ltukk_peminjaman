<x-sidebar title="Tambah Alat">
    <div class="flex justify-between items-center gap-2 flex-wrap mb-3">
        <flux:heading size="xl">Tambah Alat</flux:heading>
        <flux:button :href="route('admin.equipment.index')" icon="arrow-left" variant="outline">Kembali
        </flux:button>
    </div>
    <flux:separator />

    @livewire('livewire.equipment.create')
</x-sidebar>