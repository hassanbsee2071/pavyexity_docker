@if(isSet(auth()->user()->id))
@extends('admin.layouts.admin')

@section('title', 'Payments')

@section('content')
@endif
<link rel="stylesheet"  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div  >
	<div class="row">
        <div class="jumbotron" style="box-shadow: 2px 2px 4px #000000;">
            <h2 class="text-center">Payment Successful</h2>
          <h3 class="text-center">Thank you for your payment</h3>
          
      
          <p class="text-center">Your Transaction Id #  {{$paymentMethodRefID}}</p>
          <p class="text-center">Company Name #  {{$company_name}}</p>
          <p class="text-center">Amount #  {{$amount}}</p>

          <!-- <p class="text-center">You will receive an order confirmation email with details of your order and a link to track your process.</p> -->
            <center><div class="btn-group" style="margin-top:50px;">
                <a href="{{route('dashboard')}}" class="btn btn-lg btn-warning">CONTINUE</a>
            </div></center>
        </div>
	</div>
</div>

@if(isSet(auth()->user()->id))
@endsection

@endif