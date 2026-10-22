<x-sidebar title="Kru">
    <div class="flex justify-between gap-3 flex-wrap mb-3">
        <flux:heading size="xl">Data kru</flux:heading>
        <flux:button :href="route('admin.crew.create')" variant="primary" color="blue" icon="plus">Tambah</flux:button>
    </div>
    <flux:separator />
    @livewire('livewire.crew.table')
</x-sidebar>