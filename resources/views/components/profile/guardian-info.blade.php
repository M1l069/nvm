<div class="text-slate-500 font-medium">Tel. č. : </div>
<a href="tel:{{ phone($guardian->phone_number)->formatInternational() }}" class="text-slate-500 hover:text-blue-800">{{ phone($guardian->phone_number)->formatInternational() }}</a>
<hr class="border-slate-300 col-span-2">
<div class="col-span-2 font-medium" >Žiak</div>

@foreach($guardian->students as $student)
    <h3 class="text-slate-500 font-medium">Meno žiaka: </h3>
    <a href="{{ route('students.show', $student) }}" class="text-slate-500 hover:text-blue-800">{{ $student->user->name }}</a>
    @if($student->phone_number)
        <a href="tel:{{ phone($student->phone_number)->formatInternational() }}">{{ phone($student->phone_number)->formatInternational() }}</a>
    @endif
    @if($student->user->email)
        <a href="mailto:{{ $student->user->email }}" class="text-slate-500 hover:text-blue-800"> {{ $student->user->email }}</a>
    @endif
    <p class="text-slate-500 font-medium">Odbor žiaka: </p>
    <p class="text-slate-500"> {{ $student->specialization->department->name }}</p>
    <p class="text-slate-500 font-medium">Špecializácia: </p>
    <p class="text-slate-500">{{ $student->specialization->name }}</p>
    <p class="text-slate-500 font-medium">Bydlisko: </p>
    <p class="text-slate-500">{{ $student->street }}, {{ $student->postal_code }}, {{ $student->city }}, {{ $student->country }}</p>
@endforeach
