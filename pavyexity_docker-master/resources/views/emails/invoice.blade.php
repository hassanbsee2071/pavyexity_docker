@component('mail::message')
Hello **{{$name}}**,  {{-- use double space for line break --}}
Thank you for choosing Payvexity!

Please find the invoice in attachment
{{$body}}
@component('mail::button', ['url' => $login])
Login To Payvexity
@endcomponent

Sincerely,  
Payvexity team.
@endcomponent