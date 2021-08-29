@extends('admin.layouts.admin')
@section('title', __('SMTP Settings'))
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="col-md-3 col-sm-3 col-xs-3"></div>
        <div class="col-md-6 col-sm-6 col-xs-6" style="background-color: White; border-radius: 20px;">
            {{ Form::open(['route'=>['admin.smtp.update'],'method' => 'post','class'=>'form-horizontal form-label-left','name' => "smtpform", 'style' => 'margin-top: 20px; margin-bottom: 20px;']) }}
            <form action="{{ route('admin.smtp.update') }}" name="smtpform" class="form-horizontal form-label-left"> 

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                    SMTP Host
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="host" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('host')) parsley-error @endif" name="host" value="{{ $smtp_data->host }}" >
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_name" >
                    Username    
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="user_name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('host')) parsley-error @endif" name="user_name" value="{{ $smtp_data->user_name }}" >
                </div>
            </div>

            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                    Password
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="password" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('password')) parsley-error @endif" name="password" value="{{ $smtp_data->password }}" >
                </div>
            </div>

            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Port
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="port" type="number" class="form-control col-md-7 col-xs-12 @if($errors->has('port')) parsley-error @endif" name="port" value="{{ $smtp_data->port }}" >
                </div>
            </div>

      
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Driver
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="driver" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('driver')) parsley-error @endif" name="driver" value="{{ $smtp_data->driver }}" >
                </div>
            </div>

            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Encryption
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="encryption" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('encryption')) parsley-error @endif" name="encryption" value="{{ $smtp_data->encryption }}" >
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                From Email
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="from_address" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('from_address')) parsley-error @endif" name="from_address" value="{{ $smtp_data->from_address }}" >
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                From Name
                    <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="from_name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('from_name')) parsley-error @endif" name="from_name" value="{{ $smtp_data->from_name }}" >
                </div>
            </div>
 
            <input type="hidden" value="{{ $smtp_data->id }}" name="smtp_id">

            <div class="text-center"> 
                <button class="btn btn-dark text-white" > Update </button>
                <a href="{{ URL::previous() }}"><button class="btn btn-dark text-white" type="button" > Cancel </button></a>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    var CompanySettingList = '{{ route('admin.company') }}';
</script>
@parent
{{ Html::script('assets/admin/js/smtp/add.js') }}
@endsection
