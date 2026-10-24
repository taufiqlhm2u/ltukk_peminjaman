<x-sidebar title="Edit Alat">
    <div class="flex justify-between items-center gap-2 flex-wrap mb-3">
        <flux:heading size="xl">Edit Alat</flux:heading>
        <flux:button :href="route('admin.equipment.index')" icon="arrow-left" variant="outline">Kembali
        </flux:button>
    </div>
    <flux:separator />

    @livewire('livewire.equipment.edit', ['alat' => $alat])
</x-sidebar>