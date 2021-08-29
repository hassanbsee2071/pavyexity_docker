@extends('admin.layouts.admin')

@section('title','Select payment method to receive payment')

@section('content')

<div class="row">
@if(Session::has('errorMessage'))
<p class="alert alert-danger alert-block">{{ Session::get('errorMessage') }}</p>
@endif
    <div class="col-md-12 col-sm-12 col-xs-12">
        {{ Form::open(['route'=>['admin.payments.proccess-payment'],'method' => 'post','class'=>'form-horizontal form-label-left','name'=>'frm_payment_method']) }}
        <div class="form-group">
 
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Payment method<span class="required">*</span></label>
        
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="payment_method" onchange="change()" class="form-control col-md-7 col-xs-12 @if($errors->has('payment_method')) parsley-error @endif" name="payment_method">
                    <option value="">Select payment method</option>
                    <option value="bank_account">Bank Account</option>
                    <option value="virtual_card">Virtual Card</option>
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
        <div id="op1" style="display: none" class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
               Email
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email"  type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('email')) parsley-error @endif" name="email" value="" placeholder="Enter Account Number">
            </div>
            <br><br>
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                Account Number
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="account_number"  type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('account_number')) parsley-error @endif" name="account_number" value="" placeholder="Enter Account Number">
            </div>
        </div>
        <div id="op2" style="display: none" class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                Routing Number
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="routing_number"  type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('routing_number')) parsley-error @endif" name="routing_number" value="" placeholder="Enter Routing Number">
            </div>
        </div>
        <div id="op3"  style="display: none" class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                Account Type
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="account_type"  class="form-control col-md-7 col-xs-12 @if($errors->has('account_type')) parsley-error @endif" name="account_type">
                    <option value="">Select account type</option>
                    <option value="1">Current</option>
                    <option value="2">Saving</option>
                </select>

            </div>
        </div>
        <div id="op4" style="display: none" class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                Bank Account Name
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="bank_account_name"  type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('bank_account_name')) parsley-error @endif" name="bank_account_name" value="" placeholder="Enter Bank Account Name">
            </div>
        </div>

        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_amount">Payment Amount<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="payment_amount" type="payment_amount" class="form-control col-md-7 col-xs-12 @if($errors->has('payment_amount')) parsley-error @endif"  value="{{$Transactions->transaction_amount}}"  name="payment_amount" placeholder="0.00" />
               
            </div>
        </div>
        <!-- <div class="form-group" id="payment_type_fields">
        <input type="text" name="tId" value="{{$Transactions->id}}" >
        </div> -->
        {{ Form::hidden('tId', $Transactions->id) }}
        <div class="text-center">
            <button class="btn btn-round btn-success"> Recieve Payment</button>
        </div>
       
        {{ Form::close() }}
    </div>
</div>

<div style="display:none" id="bank_account">
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
</div>
<script>
function change(){
    d = document.getElementById("payment_method").value;
   if(d === "bank_account"){
    var op1 = document.getElementById("op1");
    var op2 = document.getElementById("op2");
    var op3 = document.getElementById("op3");
    var op4 = document.getElementById("op4");
  
    if (op1.style.display === "none") {
    op1.style.display = "block";
        }
        if (op2.style.display === "none") {
    op2.style.display = "block";
        }
        if (op3.style.display === "none") {
    op3.style.display = "block";
        }
        if (op4.style.display === "none") {
    op4.style.display = "block";
        }
   }else{
    var op1 = document.getElementById("op1");
    var op2 = document.getElementById("op2");
    var op3 = document.getElementById("op3");
    var op4 = document.getElementById("op4");
  
    if (op1.style.display === "block") {
    op1.style.display = "none";
        }
        if (op2.style.display === "block") {
    op2.style.display = "none";
        }
        if (op3.style.display === "block") {
    op3.style.display = "none";
        }
        if (op4.style.display === "block") {
    op4.style.display = "none";
        }
   }
}
</script>
@endsection
@section('scripts')
@parent
{{ Html::script('assets/admin/js/jquery.validate.min.js') }}
{{ Html::script('assets/admin/js/payments/paymentmethod.js') }}
@endsection
