@extends('admin.layouts.admin')

@section('title', 'Payments Links Edit')

@section('content')
<div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 card" style="padding-top: 12px;">
        {{ Form::open(['route'=>['online.payment.links.update', ['id' => $paymentLink->id]],'method' => 'put','class'=>'form-horizontal form-label-left', 'name' => "payment_link"]) }}
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
                <input id="name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif" name="name" value="{{ $paymentLink->name }}" >

            </div>
        </div>
        <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Enable Link
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="is_enable" type="checkbox" class="form-control @if($errors->has('is_enable')) parsley-error @endif" name="is_enable" {{ $paymentLink->is_enable ? 'checked' : '' }} >
            </div>
        </div> -->

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Enable Link
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="checkbox">
                    <label>
                    <input id="is_enable" type="checkbox" class="@if($errors->has('is_enable')) parsley-error @endif" style="height: 20px; width: 20px;" name="is_enable" {{ $paymentLink->is_enable ? 'checked' : '' }} >
                        </ul>
                    </label>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-dark text-white" > Update </button>
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
