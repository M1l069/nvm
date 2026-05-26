



<a href="{{ $href }}" @class(['rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
'text-black' => request()->routeIs($hrefName),
 'text-gray-300' => !request()->routeIs($hrefName)])>
    {{ $slot }}
</a>
