<x-layout>
    <div class="mx-auto mt-10 w-full max-w-4xl px-4 mb-4">
    <x-card>
        <x-profile.user-info :user="$user"/>
        <div class="flex mt-3 sm:justify-end">
        <a href="{{ route('user.change-password.edit') }}" class="cursor-pointer rounded-md px-3 py-2 text-sm mb-3 w-full shadow-md border border-slate-300 font-medium text-center bg-orange-600 text-black hover:bg-orange-700 sm:w-auto">Zmeniť heslo</a>
        </div>
    </x-card>
    </div>
</x-layout>
