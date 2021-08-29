@extends('admin.layouts.admin')

@section('title',__('views.admin.users.edit.title', ['name' => $user->first_name . " ". $user->last_name]) )

@section('content')
<div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 card" style="padding-top: 12px;">
        {{ Form::open(['route'=>['admin.users.update', $user->id],'method' => 'put','class'=>'form-horizontal form-label-left', 'name' => "frmuser"]) }}
        @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
        <span class="text-danger">{{ $error }}</span><br>
        @endforeach
        @endif
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">First Name<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="first_name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('first_name')) parsley-error @endif" name="first_name" value="@if(!empty($user->first_name)){{ $user->first_name }}@elseif(old('first_name')){{old('first_name')}}@endif" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name">Last Name<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="last_name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('last_name')) parsley-error @endif" name="last_name" value="@if(!empty($user->last_name)){{ $user->last_name }}@elseif(old('last_name')){{old('last_name')}}@endif" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('email')) parsley-error @endif" name="email" value="@if(!empty($user->email)){{ $user->email }}@elseif(old('email')){{old('email')}}@endif" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="phone" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('phone')) parsley-error @endif" name="phone" value="@if(!empty($user->phone)){{ $user->phone }}@elseif(old('phone')){{old('phone')}}@endif"  />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password" >
                Password
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="password" type="password" class="form-control col-md-7 col-xs-12 @if($errors->has('password')) parsley-error @endif"
                       name="password" value="" />
            </div>
        </div>


        @if(!$user->hasRole('Super User'))
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="active" >
                {{ __('views.admin.users.edit.active') }}
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="checkbox">
                    <label>
                        <input id="active" type="checkbox" class="@if($errors->has('active')) parsley-error @endif"
                               name="active" @if($user->active) checked="checked" @endif value="1">
                               @if($errors->has('active'))
                               <ul class="parsley-errors-list filled">
                            @foreach($errors->get('active') as $error)
                            <li class="parsley-required">{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </label>
                </div>
            </div>
        </div>
        @endif
        @if(1==2)
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirmed" >
                {{ __('views.admin.users.edit.confirmed') }}
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="checkbox">
                    <label>
                        <input id="confirmed" type="checkbox" class="@if($errors->has('confirmed')) parsley-error @endif"
                               name="confirmed" @if($user->confirmed) checked="checked" @endif value="1">
                               @if($errors->has('confirmed'))
                               <ul class="parsley-errors-list filled">
                            @foreach($errors->get('confirmed') as $error)
                            <li class="parsley-required">{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </label>
                </div>
            </div>
        </div>
        @endif

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
                            value="{{$role->id}}"
                            @if($user->hasRole($role->name)) checked="checked" @endif>
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
                            value="{{$module->id}}"
                            @if($user->hasPermissionToModule($module->name)) checked="checked" @endif>
                            {{ $module->name }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
        @endif

<!--        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a class="btn btn-primary" href="{{ URL::previous() }}"> {{ __('views.admin.users.edit.cancel') }}</a>
                <button type="submit" class="btn btn-success"> {{ __('views.admin.users.edit.save') }}</button>
            </div>
        </div>-->
        <div class="text-center">
            <button type="submit" class="btn btn-dark text-white">Update</button>
            <a href="{{ URL::previous() }}"><button class="btn btn-dark text-white" type="button" > {{ __('views.admin.users.edit.cancel') }} </button></a>
        </div>
        {{ Form::close() }}
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
