<div class="text-slate-500 font-medium">Dátum narodenia: </div>
<div class="text-slate-500">{{ $student->student->birth_date->format('d.m.Y') }}</div>
<div class="text-slate-500 font-medium">Bydlisko:</div>
<div class="text-slate-500">{{ $student->student->street }}, {{ $student->student->postal_code }},
    {{ $student->student->city }}, {{ $student->student->country }}</div>

<div class="text-slate-500 font-medium">Odbor: </div>
<div class="text-slate-500">{{ $student->student->specialization->department->name }}</div>
<div class="text-slate-500 font-medium">Špecializácia: </div>
<div class="text-slate-500">{{ $student->student->specialization->name }}</div>
