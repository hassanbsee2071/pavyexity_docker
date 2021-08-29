@extends('admin.layouts.admin')
@section('title', 'Add Invoice')
@section('content')

<!-- <div class="title_left">
    <h1 class="h3">Invoice Add</h1>
</div>   -->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 card" style="padding-top: 12px;">
       
        {{ Form::open(['route'=>['admin.company.invoice.save'],'method' => 'post','class'=>'form-horizontal form-label-left', 'name' => "frminvoice"]) }}
        @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
        <span class="text-danger">{{ $error }}</span><br>
        @endforeach
        @endif
        <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id">Select Client<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="user_id" id="user_id" class="form-control col-md-7 col-xs-12 js-example-tags">
                    <option value="" selected>-- Select User --</option>
                    @foreach($all_users as $user)
                    <option value="{{$user['id']}}">{{$user['email']}}</option>
                    @endforeach
                </select>
            </div>
        </div> -->
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="invoice_title">User<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id=" " type="text" class="form-control col-md-7 col-xs-12 " name="user_mail" placeholder="Enter User Email" value="" />
            </div>
        </div>
           
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="invoice_title">Invoice Title<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="invoice_title" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('invoice_title')) parsley-error @endif" name="invoice_title" value="" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="due_date">Due Date<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-group date" id="dp_due_date">
                    <input type="text" class="form-control" name="due_date" id="due_date_new" value="" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="invoice_date">Invoice Date<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-group date" id="dp_invoice_date">
                        <input type="text" class="form-control" name="invoice_date" id="invoice_date_new" value="" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- <div class="row justify-content-center d-flex dynamicField">
            <div class="col-lg-8">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                <input id="amount" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('amount')) parsley-error @endif" name="amount" value="" />
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input id="amount" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('amount')) parsley-error @endif" name="amount" value="" />
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input id="amount" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('amount')) parsley-error @endif" name="amount" value="" />
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input id="amount" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('amount')) parsley-error @endif" name="amount" value="" />
                </div>
            </div>
            </div>
        </div> --}}
        <div class="row dynamicField">
        <div class="col-lg-6">
            <div class="table-responsive">
                <!-- <form method="post" id="dynamic_form"> -->
                <span id="result"></span>
                <table class="table table-bordered table-striped" id="user_table">
                    <thead>
                        <tr>
                            <th width="">Item</th>
                            <th width="">Quantity</th>
                            <th width="">Rate</th>
                            <th width="">Amount</th>
                            <th width="">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                {{-- <tfoot>
                        <tr>
                            <td colspan="2" align="right">&nbsp;</td>
                            <td>
                                @csrf
                                <input type="submit" name="save" id="save" class="btn btn-primary" value="Save" />
                            </td>
                        </tr>
                </tfoot> --}}
                </table>
                <!-- </form> -->
            </div><br>
        </div>
        </div>

        {{-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount">Invoice Amount<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="amount" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('amount')) parsley-error @endif" name="amount" value="" />
            </div>
        </div> --}}

        

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_recurring" >
                Is recurring?
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="checkbox">
                    <label>
                        <input id="is_recurring" type="checkbox" class="" name="is_recurring"  value="1" >
                        </ul>
                    </label>
                </div>
            </div>
        </div>

        <div  >
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="recurring_period">Select Recurring Period<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="recurring_period" id="recurring_period" class="form-control col-md-7 col-xs-12">
                    <option value="">-- Select Recurring Period--</option>
                    <option value="weekly" >Weekly</option>
                    <option value="monthly" >Monthly</option>
                </select>
            </div>
        </div>
<br><br><br>
        <div class="form-group is_recurring_area">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="recurrring_end_date">Recurring End Date<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-group date" id="">
                        <input type="text" class="form-control" name="recurrring_end_date" id="recurrring_end_date_new" value="" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="text-center"> 
            <button type="submit" class="btn btn-dark text-white"> Add </button>
            <a href="{{ URL::previous() }}"><button class="btn btn-dark text-white" type="button" > {{ __('views.admin.company.invoice.show.cancel') }} </button></a>
        </div>
        {{ Form::close() }}

    </div>
</div>
@endsection
@section('scripts')
@parent
{{ Html::script('assets/admin/js/invoice/add.js') }}
@endsection

