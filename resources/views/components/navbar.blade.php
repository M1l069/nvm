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
            {{-- Hamburger button --}}
            <div>
                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-white"
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
                              d="M4 6h16M4 12h16M4 18h16"/>
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
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-transition x-cloak>
        <div class="flex flex-col items-end space-y-1 px-4 pb-4 pt-2 text-right">
            @auth
                <x-nav-link-phone :href="route('home')" href-name="home">Domov</x-nav-link-phone>
                @if (auth()->user()->role === \App\Enums\UserRole::Admin || auth()->user()->role === \App\Enums\UserRole::Teacher)
                    <x-nav-link-phone href-name="students.index" :href="route('students.index')">Žiaci
                    </x-nav-link-phone>
                @endif
                <x-nav-link-phone href="{{ route('teachers.index') }}" href-name="teachers">Učitelia</x-nav-link-phone>
                <x-nav-link-phone href="{{ route('departments.index') }}" href-name="departments">Odbory</x-nav-link-phone>
                <x-nav-link-phone href="{{ route('specializations.index') }}" href-name="specializations">Špecializácie</x-nav-link-phone>
                <x-nav-link-phone :href="route('my-events')" href-name="my-events">Moje Udalosti</x-nav-link-phone>
                @switch(auth()->user()->role)
                    @case(\App\Enums\UserRole::Admin)
                        <x-navbar.admin-mobile/>
                        @break

                    @case(\App\Enums\UserRole::Teacher)
                        <x-navbar.teacher-mobile/>
                        @break

                    @case(\App\Enums\UserRole::Student)
                        <x-navbar.student-mobile/>
                        @break

                    @case(\App\Enums\UserRole::Parent)
                        <x-navbar.guardian-mobile/>
                        @break
                @endswitch

                <x-nav-link-phone href="{{ route('profile') }}" href-name="profile">Profil</x-nav-link-phone>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="cursor-pointer rounded-md px-3 py-2 text-sm font-medium bg-orange-600 text-black hover:bg-orange-700">
                        Odhlásiť sa
                    </button>
                </form>
            @else
                <x-nav-link-phone :href="route('login')" href-name="auth.*">Prihlásiť sa</x-nav-link-phone>
            @endauth
        </div>
    </div>
</nav>
