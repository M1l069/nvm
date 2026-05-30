<a href="#" @class([
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
    Predmety
</a>
<a href="#" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('#'),
                                'text-black bg-yellow-300' => request()->routeIs('#'),
                            ])>
    Rezervacie miestností
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
