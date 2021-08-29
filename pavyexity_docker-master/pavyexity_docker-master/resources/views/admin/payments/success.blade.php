@extends('auth.layouts.auth')

@section('body_class','login')

@section('content')
<div>
    <div class="login_wrapper" style="max-width:50%">
        <div class="animate form login_form">
            <section class="login_content">

               <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <img src="{{asset('/images/logo.png')}}" width="207px" height="88px" alt="Logo" title="Logo" class="img-fluid" /><br>
                </div>
<br><br>
                    <h3>Your Payment was Successful</h3>
                    <h4>Thank you for trusting us</h4>
                    <h4>Transaction ID: {{$transactions_id}} </h4>
                    <h4>Amount: {{$amount}} </h4>
              
            </div>

          
        </section>
    </div>
</div>
</div>
@endsection

@section('styles')
@parent

{{ Html::style(mix('assets/auth/css/login.css')) }}
@endsection
@section('scripts')
@parent
@endsection