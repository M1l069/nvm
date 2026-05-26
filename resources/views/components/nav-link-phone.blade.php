<a href="{{ $href }}" @class(['block rounded-md px-3 py-2 text-base font-medium hover:bg-gray-700',
'text-black' => request()->routeIs($hrefName),
 'text-gray-300' => !request()->routeIs($hrefName)])>
    {{ $slot }}
</a>
