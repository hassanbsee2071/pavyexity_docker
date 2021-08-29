@extends('auth.layouts.auth')

@section('body_class','login')

@section('content')
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    {{ Form::open(['route' => 'login']) }}
                        <h1>{{ config('app.name') }}</h1>
                        <div>
                            <input id="email" type="email" class="form-control" name="email" value="{{ session('email') != null ? session('email') : '' }}{{ old('email') }}"
                                   placeholder="{{ __('views.auth.login.input_0') }}" required autofocus>
                        </div>
                        <div>
                            <input id="password" type="password" class="form-control" name="password"
                                   placeholder="{{ __('views.auth.login.input_1') }}" required>
                        </div>
                        <div style="display:none">
                            <input type="text" value="{{base64_encode(session('paymentType')."_".session('transactionid'))}}" name="isPaymentLink" />
                        </div>
                        <div class="checkbox al_left">
                            <label>
                                <input type="checkbox"
                                       name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('views.auth.login.input_2') }}
                            </label>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (!$errors->isEmpty())
                            <div class="alert alert-danger" role="alert">
                                {!! $errors->first() !!}
                            </div>
                        @endif

                        <div>
                            <button class="btn btn-default submit" name="login" id="login" type="submit">{{ __('views.auth.login.action_0') }}</button>
                            <a class="reset_pass" href="{{ route('password.request') }}">
                                {{ __('views.auth.login.action_1') }}
                            </a>
                        </div>

                        <div class="clearfix"></div>

        

                     
                    {{ Form::close() }}
                </section>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    @parent

    {{ Html::style(mix('assets/auth/css/login.css')) }}
@endsection