<?php

use Livewire\Component;
use App\Models\User;

new class extends Component {
    public $nama = '';
    public $email = '';
    public $password = '';
    public $konfirmasi_password = '';
    public $no_telp = '';

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:50',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|string|min:8',
            'konfirmasi_password' => 'required|same:password',
            'no_telp' => 'required|regex:/^08[0-9]+$/|min:8|max:15',
        ];
    }

    public function store()
    {
        $this->validate();
        try {
            User::create([
                'role' => 'crew',
                'name' => $this->nama,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'telpon' => $this->no_telp,
            ]);

            return redirect()->route('admin.crew.index')->with('success', 'Data kru berhasil dtambahkan.');
        } catch (\Exception) {
            $this->dispatch('alert', type: 'error', message: 'Terjadi kesalahan saat menambahkan data kru.');
        }
    }
};
?>

<div class="mt-5">
    <flux:card class="p-5">
        <form wire:submit="store">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:input placeholder="masukan nama lengkap" label="Nama lengkap" wire:model="nama" />
                </div>
                <div>
                    <flux:input placeholder="johny@gmail.com" label="Email" type="email" wire:model="email" />
                </div>
                <div>
                    <flux:input placeholder="......" label="Password" type="password" wire:model="password" viewable />
                </div>
                <div>
                    <flux:input placeholder="......" label="Konfirmasi Password" type="password"
                        wire:model="konfirmasi_password" viewable />
                </div>

                <div>
                    <flux:input placeholder="08342439232" label="No. Telp" type="tell" wire:model="no_telp" />
                </div>

            </div>
            <div class="flex justify-end gap-4 items-center mt-3">
                <flux:button variant="ghost" :href="route('admin.crew.index')">Batal</flux:button>
                <flux:button variant="primary" color="blue" type="submit">Tambah</flux:button>
            </div>
        </form>
    </flux:card>
</div>