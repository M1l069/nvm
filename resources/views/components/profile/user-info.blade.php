<h2 class="text-2xl text-center text-slate-500">Informácie o {{ $user->username }}</h2>
<div @class(['grid gap-2 text-center mt-4', ' sm:grid-cols-[220px_1fr] sm:gap-x-6
sm:gap-y-3 sm:text-left' => $user->role != \App\Enums\UserRole::Student,
' md:grid-cols-[220px_1fr] md:gap-x-6 md:gap-y-3 md:text-left' => $user-> role === \App\Enums\UserRole::Student])>
    <div class="text-slate-500 font-medium">Meno a Priezvisko: </div>
    <div class="text-slate-500">{{ $user->name }}</div>
    <div class="text-slate-500 font-medium">Používateľské meno: </div>
    <div class="text-slate-500">{{ $user->username }}</div>
    @if($user->email)
        <div class="text-slate-500 font-medium">E-mail: </div>
        <div class="text-slate-500">{{ $user->email }}</div>
    @endif
    @if($user->role === \App\Enums\UserRole::Student)
        <x-profile.student-info :student="$user"/>
        @forelse($user->student->guardians as $guardian)
            <x-profile.parent-info :parent="$guardian"/>
        @empty

        @endforelse
    @endif

    @if($user->role === \App\Enums\UserRole::Teacher)
        <x-profile.teacher-info :teacher="$user->teacher"/>
    @endif

    @if($user->role === \App\Enums\UserRole::Parent)
        <x-profile.guardian-info :guardian="$user->guardian"/>
    @endif

</div>
