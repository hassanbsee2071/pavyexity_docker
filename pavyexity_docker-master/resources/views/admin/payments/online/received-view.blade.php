@extends('admin.layouts.admin')

@section('title', 'Online Received Payments View')

@section('content')
<div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 card" style="padding-top: 12px;">
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Customers First Name<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 " name="first_name" value="First Name" readonly/>
            </div>
        </div>
<br><br>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Customers Last Name<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 " name="last_name" value="Last Name" readonly/>
            </div>
        </div>
        <br><br>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Address<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 " name="last_name" value="{{ $payment->address_line_1 }}" readonly />
            </div>
        </div>
        <br><br>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">City<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 " name="last_name" value="{{ $payment->city }}" readonly/>
            </div>
        </div>
        <br><br>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">State<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 " name="last_name" value="{{ $payment->state }}" readonly/>
            </div>
        </div>
        <br><br>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Zip<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 " name="last_name" value="{{ $payment->zipcode }}" readonly/>
            </div>
        </div>
        <br><br>


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Email<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 " name="last_name" value="{{ $payment->email }}" readonly/>
            </div>
        </div>
        <br><br>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Account Number<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 " name="last_name" value="{{ isSet($payment->account_number) ? $payment->account_number : ' '  }}" readonly />
            </div>
        </div>
        <br><br>


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Routing Number<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 " name="last_name" value="{{ isSet($payment->routing_number) ? $payment->routing_number : ' '  }}"  readonly/>
            </div>
        </div>
        <br><br>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Payment Amount<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 " name="last_name" value="{{ isSet($payment->payment_amount) ? $payment->payment_amount : ' '  }}" readonly />
            </div>
        </div>
        <br><br>

    </div>
</div>
@endsection

@section('styles')
@parent
{{ Html::style(mix('assets/admin/css/users/edit.css')) }}
@endsection

@section('scripts')
@parent
{{ Html::script(mix('assets/admin/js/users/edit.js')) }}
@endsection
