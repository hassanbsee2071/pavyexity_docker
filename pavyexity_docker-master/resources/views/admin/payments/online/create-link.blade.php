@extends('admin.layouts.admin')

@section('title', 'Add Payments Links')

@section('content')
<div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 card" style="padding-top: 12px;">
        {{ Form::open(['route'=>['online.payment.links.generate'],'method' => 'post','class'=>'form-horizontal form-label-left', 'name' => "payment_link"]) }}
        @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
        <span class="text-danger">{{ $error }}</span><br>
        @endforeach
        @endif


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Payment Link Name
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif" name="name" value="{{old('name')}}" >

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amount_req" >
                Payment Amount
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="amount_req" type="number" step="any" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif" name="amount_req" placeholder="0.00$" >
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2 col-lg-3 col-sm-3 col-xs-12" for="name" >
                Enable Link
            </label>
            <div class="col-md-1 col-sm-3 col-lg-1 col-xs-12">
                <input id="is_enable" type="checkbox" class="form-control @if($errors->has('is_enable')) parsley-error @endif" style="height: 20px; width: 20px;" name="is_enable" checked >
            </div>
            <label class="control-label col-md-2 col-lg-2 col-sm-3 col-xs-12" for="guest" >
                Enable Guest
            </label>
            <div class="col-md-1 col-sm-6 col-lg-1 col-xs-12">
                <input id="is_guest" type="checkbox" class="form-control" style="height: 20px; width: 20px;" name="is_guest" checked >
            </div>
            <label class="control-label col-md-2 col-lg-2 col-sm-3 col-xs-12" for="is_fixed" >
                Fixed Amount
            </label>
            <div class="col-md-1 col-sm-6 col-lg-1 col-xs-12">
                <input id="is_fixed" type="checkbox" class="form-control" style="height: 20px; width: 20px;" name="is_fixed" checked >
            </div>
        </div>
        <br><br>

        <div class="text-center">
            <button class="btn btn-dark text-white" > Create </button>
            <a href="{{ URL::previous() }}"><button class="btn btn-dark text-white" type="button" > Cancel </button></a>
        </div>




        {{ Form::close() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    var CompanySettingList = '{{ route('admin.company') }}';
</script>
@parent
{{ Html::script('assets/admin/js/company/add.js') }}
@endsection
