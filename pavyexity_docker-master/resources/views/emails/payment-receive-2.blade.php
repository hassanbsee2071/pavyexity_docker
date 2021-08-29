@component('mail::message')
Hello **{{$name}}**,  {{-- use double space for line break --}}
Thank you for choosing Payvexity!

You have received payment from **{{$sender}}** 

Your Payment amount is **{{$amount}}** 

Sincerely,  
Payvexity team.
@endcomponent