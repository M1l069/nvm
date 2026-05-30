<p class="text-slate-500 font-medium">Dátum narodenia: </p>
<p class="text-slate-500">{{ $student->student->birth_date->format('d.m.Y') }}</p>
<p class="text-slate-500 font-medium">Bydlisko:</p>
<p class="text-slate-500">{{ $student->student->street }}, {{ $student->student->postal_code }},
    {{ $student->student->city }}, {{ $student->student->country }}</p>

<p class="text-slate-500 font-medium">Odbor: </p>
<p class="text-slate-500">{{ $student->student->specialization->department->name }}</p>
<p class="text-slate-500 font-medium">Špecializácia: </p>
<p class="text-slate-500">{{ $student->student->specialization->name }}</p>
