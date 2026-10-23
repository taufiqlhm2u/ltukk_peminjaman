<x-sidebar title="Edit Kru">
    <div class="flex justify-between items-center gap-2 flex-wrap mb-3">
        <flux:heading size="xl">Edit Kru</flux:heading>
        <flux:button :href="route('admin.crew.index')" icon="arrow-left" variant="outline">Kembali
        </flux:button>
    </div>
    <flux:separator />

    @livewire('livewire.crew.edit', ['kru' => $kru])
</x-sidebar>