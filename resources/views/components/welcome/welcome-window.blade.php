{{-- Udalosti kapiel --}}
<section class="rounded-xl bg-white p-6 shadow-md border border-slate-100">
    <div class="mb-4 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-slate-900">
            {{ $sectionName }}
        </h2>
        {{-- Odkaz na route(band.event) --}}
        <x-welcome.welcome-components.view-all-link href="#" />
    </div>

    <div class="space-y-4">
        {{ $slot }}
    </div>
</section>
