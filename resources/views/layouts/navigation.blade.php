<nav x-data="{ open: false }" class="border-b border-slate-700 bg-slate-800 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">

            {{-- Logo Bengkel --}}
            <div class="flex">
                <div class="flex shrink-0 items-center">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                       class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600 font-bold text-white">
                            RM
                        </div>

                        <div class="leading-tight">
                            <div class="text-sm font-bold tracking-wide text-white">
                                BENGKEL ROYAL MOTOR
                            </div>
                            <div class="mt-1 text-xs text-slate-400">
                                Sistem Booking Servis
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Menu Desktop --}}
                <div class="hidden items-center space-x-1 sm:ms-8 sm:flex">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                       class="rounded-lg px-4 py-2 text-sm font-medium transition
                       {{ request()->routeIs('dashboard', 'home', 'admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                        Dashboard
                    </a>

                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.pelanggan-pesanan') }}"
                           class="rounded-lg px-4 py-2 text-sm font-medium transition
                           {{ request()->routeIs('admin.pelanggan-pesanan') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            Pelanggan
                        </a>

                        <a href="{{ route('admin.dashboard') }}"
                           class="rounded-lg px-4 py-2 text-sm font-medium transition
                           {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            Booking Servis
                        </a>

                        <a href="{{ route('admin.mekanik.index') }}"
                           class="rounded-lg px-4 py-2 text-sm font-medium transition
                           {{ request()->routeIs('admin.mekanik.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            Mekanik
                        </a>
                    @else
                        <a href="{{ route('booking.index') }}"
                           class="rounded-lg px-4 py-2 text-sm font-medium transition
                           {{ request()->routeIs('booking.index', 'booking.edit') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            Booking Servis
                        </a>

                        <a href="{{ route('booking.create') }}"
                           class="rounded-lg px-4 py-2 text-sm font-medium transition
                           {{ request()->routeIs('booking.create') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                            Buat Booking
                        </a>
                    @endif
                </div>
            </div>

            {{-- Profil Desktop --}}
            <div class="hidden items-center sm:flex">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button type="button"
                                class="inline-flex items-center gap-2 rounded-lg border border-slate-600 bg-slate-700 px-3 py-2 text-sm font-medium text-white transition hover:bg-slate-600">
                            <span>{{ Auth::user()->name }}</span>
                            <span class="rounded bg-slate-600 px-2 py-0.5 text-xs text-slate-200">
                                {{ Auth::user()->role === 'admin' ? 'Admin' : 'Pelanggan' }}
                            </span>
                            <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profil Saya
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="block w-full px-4 py-2 text-left text-sm text-red-600 transition hover:bg-slate-100">
                                Keluar
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Tombol Menu HP --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                        type="button"
                        class="inline-flex items-center justify-center rounded-lg p-2 text-slate-300 transition hover:bg-slate-700 hover:text-white">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                              class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu HP --}}
    <div x-show="open"
         x-transition
         class="border-t border-slate-700 bg-slate-800 sm:hidden">

        <div class="space-y-1 px-3 py-3">
            <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
               class="block rounded-lg px-3 py-2 text-sm font-medium transition
               {{ request()->routeIs('dashboard', 'home', 'admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                Dashboard
            </a>

            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.pelanggan-pesanan') }}"
                   class="block rounded-lg px-3 py-2 text-sm font-medium transition
                   {{ request()->routeIs('admin.pelanggan-pesanan') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    Pelanggan
                </a>

                <a href="{{ route('admin.dashboard') }}"
                   class="block rounded-lg px-3 py-2 text-sm font-medium transition
                   {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    Booking Servis
                </a>

                <a href="{{ route('admin.mekanik.index') }}"
                   class="block rounded-lg px-3 py-2 text-sm font-medium transition
                   {{ request()->routeIs('admin.mekanik.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    Mekanik
                </a>
            @else
                <a href="{{ route('booking.index') }}"
                   class="block rounded-lg px-3 py-2 text-sm font-medium transition
                   {{ request()->routeIs('booking.index', 'booking.edit') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    Booking Servis
                </a>

                <a href="{{ route('booking.create') }}"
                   class="block rounded-lg px-3 py-2 text-sm font-medium transition
                   {{ request()->routeIs('booking.create') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}">
                    Buat Booking
                </a>
            @endif
        </div>

        {{-- Akun HP --}}
        <div class="border-t border-slate-700 px-4 py-4">
            <div class="font-medium text-white">{{ Auth::user()->name }}</div>
            <div class="mt-1 text-sm text-slate-400">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}"
                   class="block rounded-lg px-3 py-2 text-sm text-slate-300 transition hover:bg-slate-700 hover:text-white">
                    Profil Saya
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="block w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-red-400 transition hover:bg-slate-700 hover:text-red-300">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>