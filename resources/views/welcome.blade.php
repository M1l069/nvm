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
        @endswitch
--}}
    <div class="flex justify-start  items-center mt-4 ml-2">
        <h3 class="text-xl">Vitajte {{ auth()->user()->name }}</h3>

    </div>
</x-layout>
