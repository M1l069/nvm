<x-layout>
    <x-dashboard.common :$user>
        @switch($user->role)
            @case(\App\Enums\UserRole::Student)
                <x-dashboard.student :$user />
                @break

            @case(\App\Enums\UserRole::Parent)
                <x-dashboard.guardian :$user />
                @break

            @case(\App\Enums\UserRole::Teacher)
                <x-dashboard.teacher :$user />
                @break

            @case(\App\Enums\UserRole::Admin)
                <x-dashboard.admin :$user :$bands :events="$userEvents"/>
                @break
        @endswitch
    </x-dashboard.common>


</x-layout>
