@component('mail::message')
Hello **{{$name}}**,  {{-- use double space for line break --}}
Thank you for choosing Payvexity!

Your account is registered with **Payvexity** by {{$sender}}

Your account details are:
**Email**: {{$email}}
**Password**: {{$password}}

You can click this button to use your login
@component('mail::button', ['url' => $link])
Login
@endcomponent

Sincerely,  
Payvexity team.
@endcomponent