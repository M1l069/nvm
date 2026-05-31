<a href="{{ route('events.index') }}" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('events.index'),
                                'text-black bg-yellow-300' => request()->routeIs('events.index'),
                            ])>
    Udalosti
</a>

<a href="#" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('#'),
                                'text-black bg-yellow-300' => request()->routeIs('#'),
                            ])>
    Predmety
</a>
<a href="#" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('#'),
                                'text-black bg-yellow-300' => request()->routeIs('#'),
                            ])>
    Známky
</a>
<a href="#" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('#'),
                                'text-black bg-yellow-300' => request()->routeIs('#'),
                            ])>
    Rezervácie nástrojov
</a>
<a href="#" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('#'),
                                'text-black bg-yellow-300' => request()->routeIs('#'),
                            ])>
    Kapely
</a>
