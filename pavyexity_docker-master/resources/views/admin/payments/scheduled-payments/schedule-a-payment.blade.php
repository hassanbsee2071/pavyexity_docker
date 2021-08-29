@extends('admin.layouts.admin')

@section('title','Add Recurring Payments')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        {{ Form::open(['route'=>['admin.payments.schedule.add'],'method' => 'post','class'=>'form-horizontal form-label-left card', 'style' => 'padding-top: 20px;' ,'name'=>'frmschedulepayment']) }}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                Email
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" type="email" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif" name="email" value="" placeholder="Enter email">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="schedule_interval">
            Interval
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="schedule_interval" name="schedule_interval" class="form-control">
                    <option value=""> Select Interval </option>
                    <option value="annually">Annually</option>
                    <option value="semi-annually">Semi Annually</option>
                    <option value="quaterly">Quarterly</option>
                    <option value="monthly">Monthly </option>
                    <option value="weekly">Weekly</option>
                    <option value="daily">Daily</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="start_date">Start Date<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-group date">
                        <input type="text" class="form-control valid" name="start_date" id="start_date" value="" aria-invalid="false">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_date">End Date<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-group date">
                        <input type="text" class="form-control valid" name="end_date" id="end_date" value="" aria-invalid="false">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_amount">Payment Amount<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" id="payment_amount" step="any" type="payment_amount" class="form-control col-md-7 col-xs-12 @if($errors->has('payment_amount')) parsley-error @endif" name="payment_amount" placeholder="0.00" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                Description
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea id="description" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif" name="description" value="" placeholder="Enter description"></textarea>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-round btn-success"> Schedule </button>

            <a class="btn btn-round btn-danger" href="{{url()->previous()}}"> Cancel </a>
        </div>
        {{ Form::close() }}
    </div>
</div>

@endsection
@section('scripts')
@parent
{{ Html::script('assets/admin/js/jquery.validate.min.js') }}
{{ Html::script('assets/admin/js/scheduledpayment/schedulepayment.js') }}
@endsection
