@component('mail::message')
Hello **{{$name}}**,  {{-- use double space for line break --}}
Thank you for choosing Payvexity!

You have received recurring payment from **{{$sender}}** 

Your Recurring Payment amount is **{{$amount}}** 

Your Recurring Payment type is **{{$type}}** 


Sincerely,  
Payvexity team.
@endcomponent