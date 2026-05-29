<nav x-data="{ open: false }" class="bg-white shadow-md">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            {{-- Logo / názov aplikácie --}}
            <div class="flex items-center">
                <a href="/" class="text-lg font-semibold text-white">
                    <img src="{{ asset('logo.png') }}" alt="logo">
                </a>
                <a href="/" class="text-yellow-300 font-medium text-xl hover:text-yellow-400">ISŠHU</a>
            </div>

            {{-- Desktop menu --}}
            <div class="hidden md:flex md:items-center md:space-x-4">
                @auth
                    <a href="{{ route('home') }}"
                        @class([
                            'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                            'text-gray-300' => !request()->routeIs('home'),
                            'text-black bg-yellow-300' => request()->routeIs('home'),
                        ])>
                        Domov
                    </a>
                    @if (auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                        <a href="{{ route('students.index') }}"
                            @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('students.index'),
                                'text-black bg-yellow-300' => request()->routeIs('students.index'),
                            ])>
                            Žiaci
                        </a>
                    @endif
                    <a href="/teachers" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-yellow-300 hover:text-black">
                        Učitelia
                    </a>

                    <a href="/events" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-yellow-300 hover:text-black">
                        Udalosti
                    </a>
                    <a href="{{ route('profile') }}"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" class="h-7 w-7">
                        <circle cx="50" cy="50" r="50" fill="#e5e7eb"/>
                        <circle cx="50" cy="36" r="18" fill="#6b7280"/>
                        <path d="M20 88c4-22 18-34 30-34s26 12 30 34" fill="#6b7280"/>
                    </svg> </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cursor-pointer rounded-md px-3 py-2 text-sm font-medium bg-orange-600 text-black hover:bg-orange-700">Odhlásiť sa</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" @class(['rounded-md px-3 py-2 text-sm font-medium
                    hover:bg-yellow-300 hover:text-black', 'text-gray-300' => !request()->routeIs('auth.create'),
                    'text-black bg-yellow-300' => request()->routeIs('auth.create')])>
                        Prihlásiť sa
                    </a>
                @endauth
            </div>

            {{-- Hamburger button --}}
            <div class="md:hidden">
                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                >
                    <span class="sr-only">Otvoriť menu</span>

                    {{-- Hamburger ikona --}}
                    <svg
                        x-show="!open"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    {{-- X ikona --}}
                    <svg
                        x-show="open"
                        x-cloak
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-transition x-cloak class="md:hidden">
        <div class="space-y-1 px-4 pb-4 pt-2">
            @auth
                <x-nav-link-phone :href="route('home')" href-name="home">Domov</x-nav-link-phone>
                @if (auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                <x-nav-link-phone href-name="students.index" :href="route('students.index')">Žiaci</x-nav-link-phone>
                @endif
                <x-nav-link-phone href="/teachers" href-name="teachers">Učitelia</x-nav-link-phone>
                <x-nav-link-phone href="/events" href-name="events">Udalosti</x-nav-link-phone>
                <x-nav-link-phone href="{{ route('profile') }}" href-name="profile">Profil</x-nav-link-phone>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="cursor-pointer rounded-md px-3 py-2 text-sm font-medium bg-orange-600 text-black hover:bg-orange-700">Odhlásiť sa</button>
                </form>
            @else
                <x-nav-link-phone :href="route('login')" href-name="auth.*">Prihlásiť sa</x-nav-link-phone>
            @endauth
        </div>
    </div>
</nav>
