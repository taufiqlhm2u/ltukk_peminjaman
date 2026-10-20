<x-layout>
    <div class="w-full min-h-screen flex justify-center items-center">
        <flux:card class="w-100 p-3">
            <div class="mb-3">
                <flux:heading size="xl">Login</flux:heading>
                <flux:text>Masuk ke sistem peminjaman</flux:text>
            </div>
            <flux:separator />

            <form action="{{ route('login.verif') }}" method="post" class="mt-2">
                @csrf
                <div class="mb-3">
                    <flux:input name="email" type="email" placeholder="john@gmail.com" label="Email"
                        value="{{ old('email', '') }}" />
                </div>

                <div class="mb-3">
                    <flux:input name="password" type="password" label="Password" viewable />
                </div>

                <div>
                    <flux:button variant="primary" type="submit" class="w-full">Login</flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-layout>
