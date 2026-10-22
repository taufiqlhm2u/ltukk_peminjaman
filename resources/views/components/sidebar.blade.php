@props([
    'title' => null,
])
<x-layout :title="$title">
    <flux:sidebar sticky collapsible="mobile" class="bg-white border-r border-r-zinc-300">
        <flux:sidebar.header>
            <flux:brand href="/">{{ config('app.name') }}</flux:brand>
            <flux:sidebar.collapse class="md:hidden" />
        </flux:sidebar.header>


        <flux:sidebar.nav>
            <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')">
                Dashboard
            </flux:sidebar.item>
            <flux:sidebar.item icon="user" :href="route('admin.operator.index')" :current="request()->routeIs('admin.operator*')">
                Petugas
            </flux:sidebar.item>
            <flux:sidebar.item icon="briefcase" :href="route('admin.crew.index')" :current="request()->routeIs('admin.crew*')">Kru</flux:sidebar.item>
        </flux:sidebar.nav>

        <flux:sidebar.spacer />

        <flux:dropdown postion="top" align="start" class="max-lg:hidden">
            <flux:sidebar.profile :name="auth()->user()->name" />

            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio>{{ auth()->user()->name }}</flux:menu.radio>
                </flux:menu.radio.group>

                <flux:separator />
                <flux:menu.item class="text-red-500! hover:bg-red-200!">
                    <flux:modal.trigger name="logout"> <flux:icon.arrow-right-start-on-rectangle /> Logout</flux:modal.trigger>
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <flux:modal name="logout">
        <div>
            <flux:heading class="mb-4">Konfirmasi Keluar</flux:heading>
            <flux:text>
                Apakah kamu yakin engnin keluar?
            </flux:text>
        </div>
        <form action="{{ route('logout') }}" method="post" class="mt-4 flex justify-between">
            @csrf
            <flux:modal.close>
                <flux:button size="sm" variant="ghost">Batal</flux:button>
            </flux:modal.close>
            <flux:button variant="danger" size="sm" type="submit">Ya, Logout</flux:button>
        </form>
    </flux:modal>

    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layout>
