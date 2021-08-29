@extends('auth.layouts.auth')

@section('body_class','login')

@section('content')
<div>
    <div class="login_wrapper" style="max-width:50%">
        <div class="animate form login_form">
            <section class="login_content">
               <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    {{ Form::open(['route'=>['online.payment'],'method' => 'post','class'=>'form-horizontal form-label-left','name'=>'frm_payment_method']) }}
                    <input type="hidden" name="company_id" value="{{$company_id}}" />
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Payment method<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="payment_method" class="form-control col-md-7 col-xs-12 @if($errors->has('payment_method')) parsley-error @endif" name="payment_method">
                                <option value="">Select payment method</option>
                                <option value="bank_account">Bank Account</option>
                                <option value="credit_card">Credit Card</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                            Name
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="name" type="name" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif" name="name" value="" placeholder="Enter name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_amount">Payment Amount<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="payment_amount" type="payment_amount" class="form-control col-md-7 col-xs-12 @if($errors->has('payment_amount')) parsley-error @endif" name="payment_amount" placeholder="0.00" value="{{$if_amount == 1 ? $amount :''}}" />

                        </div>
                    </div>
                    <!--<div id="bank_account">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_number">Account Number<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="account_number" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('account_number')) parsley-error @endif" name="account_number" placeholder="Enter bank account number." />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="routing_number">Routing Number<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="routing_number" type="number" class="form-control col-md-7 col-xs-12 @if($errors->has('routing_number')) parsley-error @endif" name="routing_number" placeholder="Enter bank routing number." />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_type">Account Type<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select id="account_type" class="form-control col-md-7 col-xs-12 @if($errors->has('account_type')) parsley-error @endif" name="account_type">
                                    <option value="">Select account type </option>
                                    <option value="1">Checking</option>
                                    <option value="2">Savings</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_account_name">Bank Account Name<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="bank_account_name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('bank_account_name')) parsley-error @endif" name="bank_account_name" placeholder="Enter bank account name." />
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group" id="payment_type_fields">

                    </div>
                    <div class="text-center">
                        <button class="btn btn-round btn-success"> Pay</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>

            <div style="display:none" id="bank_account">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_number">Account Number<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="account_number" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('account_number')) parsley-error @endif" name="account_number" placeholder="Enter bank account number" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="routing_number">Routing Number<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="routing_number" type="number" class="form-control col-md-7 col-xs-12 @if($errors->has('routing_number')) parsley-error @endif" name="routing_number" placeholder="Enter bank routing number" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_type">Account Type<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select id="account_type" class="form-control col-md-7 col-xs-12 @if($errors->has('account_type')) parsley-error @endif" name="account_type">
                            <option value="">Select account type </option>
                            <option value="1">Checking</option>
                            <option value="2">Savings</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_account_name">Bank Account Name<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="bank_account_name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('bank_account_name')) parsley-error @endif" name="bank_account_name" placeholder="Enter bank account name" />
                    </div>
                </div>
            </div>

            <div style="display:none" id="credit_card">
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_number">Card Holder Name<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="card_holder_name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('card_holder_name')) parsley-error @endif" name="card_holder_name" placeholder="Enter card holder name" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="card_number">Credit Card Number<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="card_number" type="number" class="form-control col-md-7 col-xs-12 @if($errors->has('card_number')) parsley-error @endif" name="card_number" placeholder="Enter credit card number" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="card_address1">Address line 1<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="card_address1" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('card_address1')) parsley-error @endif" name="card_address1" placeholder="Enter credit card owner address line 1" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="card_address2">Address line 2</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="card_address2" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('card_address2')) parsley-error @endif" name="card_address2" placeholder="Enter credit card owner address line 2" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="card_city">City<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="card_city" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('card_city')) parsley-error @endif" name="card_city" placeholder="Enter credit card city name" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="card_state">State<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="card_state" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('card_state')) parsley-error @endif" name="card_state" placeholder="Enter credit card state name" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="card_country">Country<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="card_country" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('card_country')) parsley-error @endif" name="card_country" placeholder="Enter credit card country name" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="card_zipcode">Zipcode<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="card_zipcode" type="number" class="form-control col-md-7 col-xs-12 @if($errors->has('card_zipcode')) parsley-error @endif" name="card_zipcode" placeholder="Enter credit card zipcode" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="card_cvv">CVV<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="card_cvv" type="number" class="form-control col-md-7 col-xs-12 @if($errors->has('card_cvv')) parsley-error @endif" name="card_cvv" placeholder="CVV" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="card_expiry_month">Expiry month<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="card_expiry_month" type="number" class="form-control col-md-7 col-xs-12 @if($errors->has('card_cvv')) parsley-error @endif" name="card_expiry_month" placeholder="Month" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="card_expiry_year">Expiry Year<span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="card_expiry_year" type="number" class="form-control col-md-7 col-xs-12 @if($errors->has('card_expiry_year')) parsley-error @endif" name="card_expiry_year" placeholder="Year" />
                    </div>
                </div>
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
{{ Html::script('assets/admin/js/jquery.validate.min.js') }}
{{ Html::script('assets/admin/js/payments/paymentmethod.js') }}
@endsection
