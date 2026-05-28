<div class="mx-auto w-full max-w-7xl px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-slate-900">
            Vitajte, {{ $user->name }}
        </h1>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        {{ $slot }}
    </div>
</div>
