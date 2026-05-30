<hr class="border-slate-300 col-span-1 sm:col-span-2">
<h2 class="col-span-2 font-medium"> Zákonný zástupca žiaka</h2>
<p class="text-slate-500 font-medium">Meno Rodiča: </p>
<p class="text-slate-500">{{ $parent->user->name }}</p>
<p class="text-slate-500 font-medium">Používateľské meno rodiča: </p>
<p class="text-slate-500">{{ $parent->user->username }}</p>
<p class="text-slate-500 font-medium">E-mail rodiča: </p>
<a href="mailto:{{ $parent->user->email  }}" class="text-slate-500 hover:text-blue-800">{{ $parent->user->email }}</a>
<p class="text-slate-500 font-medium">Tel. č. rodiča: </p>
<a href="tel:{{ phone($parent->phone_number)->formatInternational() }}" class="text-slate-500 hover:text-blue-800">{{ phone($parent->phone_number)->formatInternational() }}</a>
