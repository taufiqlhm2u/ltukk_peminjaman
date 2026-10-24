<x-sidebar title="Alat">
    <div class="flex justify-between gap-3 flex-wrap mb-3">
        <flux:heading size="xl">Data Alat</flux:heading>
        <flux:button :href="route('admin.equipment.create')" variant="primary" color="blue" icon="plus">Tambah</flux:button>
    </div>
    <flux:separator />
    @livewire('livewire.equipment.table')
</x-sidebar>