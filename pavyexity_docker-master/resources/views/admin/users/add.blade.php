@extends('admin.layouts.admin')
@section('title', 'Add User')
@section('content')
<!-- <div class="title_left">
    <h1 class="h3">User Add</h1>
</div> -->
<div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 card" style="padding-top: 12px;">
        {{ Form::open(['route'=>['admin.users.save'],'method' => 'post','class'=>'form-horizontal form-label-left', 'name' => "frmuser"]) }}
        @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
        <span class="text-danger">{{ $error }}</span><br>
        @endforeach
        @endif
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">First Name<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('first_name')) parsley-error @endif" name="first_name" value="{{old('first_name')}}" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name">Last Name<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="last_name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('last_name')) parsley-error @endif" name="last_name" value="{{old('last_name')}}" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('email')) parsley-error @endif" name="email" value="{{old('email')}}" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="phone" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('phone')) parsley-error @endif" name="phone" value="{{old('phone')}}" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password" >
                Password
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password" type="password" class="form-control col-md-7 col-xs-12 @if($errors->has('password')) parsley-error @endif" name="password" value="{{old('password')}}" />
            </div>
        </div>
        @if(isSuperAdmin())
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirmed" >
                Select roles
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                @foreach($roles as $role)
                <div class="checkbox">
                    <label>
                        <input
                            type="checkbox"
                            name="roles[]"
                            value="{{$role->id}}">
                            {{ $role->name }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isSuperAdmin())
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirmed" >
                Select Access
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                @foreach($modules as $module)
                <div class="checkbox">
                    <label>
                        <input
                            type="checkbox"
                            name="modules[]"
                            value="{{$module->id}}">
                            {{ $module->name }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        @elseif(isAdmin())
        <div class="form-group">
            <input type="checkbox" hidden name="modules[]" checked value="7">               
            <input type="checkbox" hidden name="modules[]" checked value="9">                              
        </div>

        @endif
        <div class="text-center">
            <button type="submit" class="btn btn-dark text-white"> Add </button>
            <a href="{{ URL::previous() }}"><button class="btn btn-dark text-white" type="button" > {{ __('views.admin.users.edit.cancel') }} </button></a>
        </div>
        {{ Form::close() }}
    </div>
</div>
@endsection
@section('scripts')
@parent
{{ Html::script('assets/admin/js/users/add.js') }}
@endsection

