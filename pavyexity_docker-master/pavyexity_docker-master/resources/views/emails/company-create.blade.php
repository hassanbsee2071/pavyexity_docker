@component('mail::message')
Hello **{{$name}}**,  {{-- use double space for line break --}}
Thank you for choosing Payvexity!

Your account is registered with **Payvexity** with admin role assigned to  **{{$root}}**
{!! $body !!}
Your account is associated with:
Email: {{$email}}

Sincerely,  
Payvexity team.
@endcomponent