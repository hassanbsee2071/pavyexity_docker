@extends('admin.layouts.admin')
@section('title', 'Invoice Update')
@section('content')

<!-- <div class="title_left">
    <h1 class="h3">Invoice Update</h1> 
</div>   -->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 card" style="padding-top: 12px;">
        @if(isset($invoice_data))

        {{ Form::open(['route'=>['admin.company.invoice.update', $invoice_data->id],'method' => 'post','class'=>'form-horizontal form-label-left', 'name' => "frminvoice"]) }}
        @else
        {{ Form::open(['route'=>['admin.company.invoice.save'],'method' => 'post','class'=>'form-horizontal form-label-left', 'name' => "frminvoice"]) }}
        @endif
        @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
        <span class="text-danger">{{ $error }}</span><br>
        @endforeach
        @endif
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="invoice_title">User<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
          
                <input id=" " type="text" class="form-control col-md-7 col-xs-12 " name="user_mail" placeholder="Enter User Email" value="{{$invoice_data->email}}" />
               
            </div>
        </div> 
        <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id">Select Client<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="user_id" id="user_id" class="form-control col-md-7 col-xs-12 js-example-tags">
                    <option value="" @if(empty($invoice_data)){{"selected"}}@endif>-- Select User --</option>
                    @foreach($all_users as $user)
                    <option value="{{$user['id']}}" @if(!empty($invoice_data) && !empty($invoice_data->user_id) && $invoice_data->user_id==$user['id']){{"selected"}}@endif>{{$user['email']}}</option>
                    @endforeach
                </select>
            </div>
        </div> -->

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="invoice_title">Invoice Title<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="invoice_title" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('invoice_title')) parsley-error @endif" name="invoice_title" value="@if(!empty($invoice_data) && !empty($invoice_data->invoice_title)){{$invoice_data->invoice_title}}@elseif(old('invoice_title')){{old('invoice_title')}}@endif" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="due_date">Due Date<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-group date" id="dp_due_date">
                    <input type="text" class="form-control" name="due_date" id="due_date_new" value="{{$invoice_data->due_date}}" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="due_date">Due Date<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-group date" id="dp_due_date">
                        <input type="text" class="form-control" name="due_date" id="datepicker"value="{{$invoice_data->due_date}}" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        </div> -->
        
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="invoice_date">Invoice Date<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-group date" id="dp_invoice_date">
                        <input type="text" class="form-control" name="invoice_date" id="invoice_date_new" value="{{$invoice_data->invoice_date}}" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="invoice_date">Invoice Date<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-group date" id="dp_invoice_date">
                        <input type="text" class="form-control" name="invoice_date" id="invoice_date" value={{$invoice_data->invoi}}/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        </div> -->

        {{-- <div class="row justify-content-center d-flex dynamicField">
            <div class="col-lg-8">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input id="amount" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('amount')) parsley-error @endif" name="amount" value="@if(!empty($invoice_data) && !empty($invoice_data->amount)){{$invoice_data->amount}}@elseif(old('amount')){{old('amount')}}@endif" />
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input id="amount" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('amount')) parsley-error @endif" name="amount" value="@if(!empty($invoice_data) && !empty($invoice_data->amount)){{$invoice_data->amount}}@elseif(old('amount')){{old('amount')}}@endif" />
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input id="amount" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('amount')) parsley-error @endif" name="amount" value="@if(!empty($invoice_data) && !empty($invoice_data->amount)){{$invoice_data->amount}}@elseif(old('amount')){{old('amount')}}@endif" />
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <input id="amount" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('amount')) parsley-error @endif" name="amount" value="@if(!empty($invoice_data) && !empty($invoice_data->amount)){{$invoice_data->amount}}@elseif(old('amount')){{old('amount')}}@endif" />
                </div>
            </div>
            </div>
        </div> --}}
        <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12"></div>
        <div class="col-md-6 col-xs-12">
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
                        </tr>
                    </thead>
                    @foreach($items as $itema)
                    <tbody>
                    <td width=""><input type="text" name="item[]" id="item" value="{{$itema->item[0]}}" class="form-control" /></td>
                    <td><input type="text" name="quantity[]" id="quantity" value="{{$itema->quantity[0]}}" class="form-control" onkeyup="sum()"/></td>
                    <td><input type="text" name="rate[]" id="rate" value="{{$itema->rate[0]}}" class="form-control" onkeyup="sum()"/></td>
                    <td><input type="text" name="amounts[]" id="amounts"  value="" class="form-control" readonly/></td>

                    </tbody>
                    @endforeach
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
                <input id="amount" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('amount')) parsley-error @endif" name="amount" value="@if(!empty($invoice_data) && !empty($invoice_data->amount)){{$invoice_data->amount}}@elseif(old('amount')){{old('amount')}}@endif" />
            </div>
        </div> --}}

        @if(!empty($invoice_id))
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id">Select Status<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="invoice_status" id="invoice_status" class="form-control col-md-7 col-xs-12">
                    <option value="">-- Select Status --</option>
                    <option value="sent" @if(!empty($invoice_data) && $invoice_data->status=='sent'){{"selected"}}@endif>Sent</option>
                    <option value="paid" @if(!empty($invoice_data) && $invoice_data->status=='paid'){{"selected"}}@endif>Paid</option>
                </select>
            </div>
        </div>
        @endif

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_recurring" >
                Is recurring?
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="checkbox">
                    <label>
                        <input id="is_recurring" type="checkbox" class="" name="is_recurring"  value="1" @if(!empty($invoice_data) && $invoice_data->is_recurring=='1'){{"checked"}}@endif>
                        </ul>
                    </label>
                </div>
            </div>
        </div>

        <div  @if(!empty($invoice_data) && $invoice_data->is_recurring=='0') style="display: none;" @elseif(!empty($invoice_data) && $invoice_data->is_recurring=='1') style="display: block;" @else empty($invoice_data)  style="display: none;"   @endif  class="form-group is_recurring_area">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="recurring_period">Select Recurring Period<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="recurring_period" id="recurring_period" class="form-control col-md-7 col-xs-12">
                    <option value="">-- Select Recurring Period--</option>
                    <option value="weekly" @if(!empty($invoice_data) && $invoice_data->recurring_period=='weekly'){{"selected"}}@endif>Weekly</option>
                    <option value="monthly" @if(!empty($invoice_data) && $invoice_data->recurring_period=='monthly'){{"selected"}}@endif>Monthly</option>
                </select>
            </div>
        </div>

        <div @if(!empty($invoice_data) && $invoice_data->is_recurring=='0') style="display: none;" @elseif(!empty($invoice_data) && $invoice_data->is_recurring=='1') style="display: block;" @else empty($invoice_data)  style="display: none;"   @endif  class="form-group is_recurring_area">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="recurrring_end_date">Recurring End Date<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-group date" id="">
                        <input type="text" class="form-control" name="recurrring_end_date" id="recurrring_end_date_new_2" value="{{$invoice_data->recurrring_end_date}}"  />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($invoice_id))
        <div class="text-center"> 
            <button type="submit" class="btn btn-dark text-white"> Update </button>
            <a href="{{ URL::previous() }}"><button class="btn btn-dark text-white" type="button" > {{ __('views.admin.company.invoice.show.cancel') }} </button></a>
        </div>
        @else
        <div class="text-center"> 
            <button type="submit" class="btn btn-dark text-white"> Add </button>
            <a href="{{ URL::previous() }}"><button class="btn btn-dark text-white" type="button" > {{ __('views.admin.company.invoice.show.cancel') }} </button></a>
        </div>
        @endif
        <input type="hidden" name="invoice_id" value="@if(!empty($invoice_id)){{$invoice_id}}@endif">
        {{ Form::close() }}

    </div>
</div>
    <script type="text/javascript">
        function sum() {
            var txtFirstNo = document.getElementById('quantity').value;
            var txtSecondNo = document.getElementById('rate').value;
            var result = parseInt(txtFirstNo) * parseInt(txtSecondNo);
            if (!isNaN(result)) {
                document.getElementById('amounts').value = result;
            }
        }
    </script>
@endsection
@section('scripts')
@parent
{{ Html::script('assets/admin/js/invoice/edit.js') }}
@endsection

