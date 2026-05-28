<x-layout>
    <div class="flex items-center justify-center px-4 py-10 sm:items-center sm:py-16">
        <article class="w-full max-w-lg rounded-xl border border-slate-300 bg-white p-6 shadow-md sm:p-8">
            <h1 class="mb-8 text-center text-3xl font-semibold sm:text-4xl">Zmena hesla</h1>
            <form action="{{ route('user.change-password.update') }}" class="space-y-5" method="POST">
                @csrf
                @method('PATCH')
                <x-auth.password-input label="Heslo: " name="password"/>
                <x-auth.password-input label="Potvrďte heslo: " name="password_confirmation"/>
                <div class="mt-3 pt-2 flex justify-end">
                    <button
                        type="submit"
                        class="w-full cursor-pointer rounded-md
                        bg-yellow-300 px-4 py-3 font-medium text-black shadow-md
                        hover:bg-yellow-500 sm:w-auto sm:px-6">
                        Zmeniť heslo
                    </button>
                </div>
            </form>
        </article>
    </div>
</x-layout>
