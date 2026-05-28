<div class="text-slate-500 font-medium">Tel. č. : </div>
<div class="text-slate-500">{{ $guardian->phone_number }}</div>
<hr class="border-slate-300 col-span-2">
<div class="col-span-2 font-medium" >Žiak</div>

@foreach($guardian->students as $student)
    <div class="text-slate-500 font-medium">Meno žiaka: </div>
    <div class="text-slate-500">{{ $student->user->name }}</div>
    <div class="text-slate-500 font-medium">Odbor žiaka: </div>
    <div class="text-slate-500"> {{ $student->specialization->department->name }}</div>
    <div class="text-slate-500 font-medium">Špecializácia: </div>
    <div class="text-slate-500">{{ $student->specialization->name }}</div>
    <div class="text-slate-500 font-medium">Bydlisko: </div>
    <div class="text-slate-500">{{ $student->street }}, {{ $student->postal_code }}, {{ $student->city }}, {{ $student->country }}</div>
@endforeach
