@extends('admin.layouts.admin')
@section('title', 'Edit Email Template')
@section('content')
<div class="row">
    <div  class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 card" style="padding-top: 12px;">
        {{ Form::open(['route'=>['admin.email_template.update', $email_template->id],'method' => 'post','class'=>'form-horizontal form-label-left','name'=>'frmemailtemplate']) }}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email_subject" >
                Email Subject
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif"
                        name="email_subject" value="{{$email_template->email_subject}}">
                        @if($errors->has('name'))
                <ul class="parsley-errors-list filled">
                    @foreach($errors->get('name') as $error)
                    <li class="parsley-required">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email_slug" >
                Email Subject
                <span class="required">*</span>
            </label>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email_slug" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif"
                        name="email_slug" value="{{$email_template->email_slug}}">
                        @if($errors->has('name'))
                <ul class="parsley-errors-list filled">
                    @foreach($errors->get('name') as $error)
                    <li class="parsley-required">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email_content" >
                Email Body Content
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea name="email_content" required>{{ $email_template->email_body }}</textarea>
                @if($errors->has('name'))
                    <ul class="parsley-errors-list filled">
                        @foreach($errors->get('name') as $error)
                        <li class="parsley-required">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
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
@parent
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
{{ Html::script('assets/admin/js/email_template/add.js') }}
@endsection
