<x-layout>
{{--
php artisan make:component Dashboard/Admin
php artisan make:component Dashboard/Teacher
php artisan make:component Dashboard/Student
php artisan make:component Dashboard/Guardian
 @switch(auth()->user()->role->value ?? auth()->user()->role)
            @case('admin')
                <x-dashboard.admin />
                @break

            @case('teacher')
                <x-dashboard.teacher />
                @break

            @case('student')
                <x-dashboard.student />
                @break

            @case('guardian')
                <x-dashboard.guardian />
                @break
        @endswitch--}}
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
