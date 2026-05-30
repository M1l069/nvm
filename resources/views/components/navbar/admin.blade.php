<a href="{{ route('teachers.index') }}" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('teachers.index'),
                                'text-black bg-yellow-300' => request()->routeIs('teachers.index'),
                            ])>
    Udalosti
</a>

<a href="{{ route('teachers.index') }}" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('teachers.index'),
                                'text-black bg-yellow-300' => request()->routeIs('teachers.index'),
                            ])>
    Predmety
</a>
<a href="{{ route('teachers.index') }}" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('teachers.index'),
                                'text-black bg-yellow-300' => request()->routeIs('teachers.index'),
                            ])>
    Rezervacie miestností
</a>
<a href="{{ route('teachers.index') }}" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('teachers.index'),
                                'text-black bg-yellow-300' => request()->routeIs('teachers.index'),
                            ])>
    Rezervácie nástrojov
</a>
<a href="{{ route('teachers.index') }}" @class([
                                'rounded-md px-3 py-2 text-sm font-medium hover:bg-yellow-300 hover:text-black',
                                'text-gray-300' => !request()->routeIs('teachers.index'),
                                'text-black bg-yellow-300' => request()->routeIs('teachers.index'),
                            ])>
    Kapely
</a>

