@component('mail::message')
Hello **{{$name}}**,  {{-- use double space for line break --}}
Thank you for choosing Payvexity!

You have received payment from {{$sender}}
@component('mail::button', ['url' => $link])
Proceed with Payment
@endcomponent

Sincerely,  
Payvexity team.
@endcomponent