<a href="{{ route('events.index') }}" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('#'),
                                'text-black bg-yellow-300' => request()->routeIs('#'),
                            ])>
    Udalosti
</a>

<a href="#" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('#'),
                                'text-black bg-yellow-300' => request()->routeIs('#'),
                            ])>
    Známky žiaka
</a>
<a href="#" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('#'),
                                'text-black bg-yellow-300' => request()->routeIs('#'),
                            ])>
    Rezervácie nástrojov pre žiaka
</a>
<a href="#" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('#'),
                                'text-black bg-yellow-300' => request()->routeIs('#'),
                            ])>
    Rozvrh žiaka
</a>
<a href="#" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('#'),
                                'text-black bg-yellow-300' => request()->routeIs('#'),
                            ])>
    Kapely žiaka
</a>


