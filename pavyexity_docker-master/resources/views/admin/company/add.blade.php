@extends('admin.layouts.admin')
@section('title', 'Add Company')
@section('content')
<div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 card" style="padding-top: 12px;">
        {{ Form::open(['route'=>['admin.company.company_save'],'method' => 'post','class'=>'form-horizontal form-label-left', 'name' => "frmcompany"]) }}
        @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
        <span class="text-danger">{{ $error }}</span><br>
        @endforeach
        @endif
        @if(isSuperAdmin())
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_admin" >Company Admin<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="company_admin[]" id="company_admin"  class="form-control @if($errors->has('company_admin')) parsley-error @endif">
                    <option value="" @if(old('company_admin')==""){{"selected"}}@endif>-- Select Company Admin --</option>
                    @if(!empty($company_data))
                    @foreach($company_data as $admin)
                    <option onchange ="captureID()" value="{{$admin->id}}" @if(old('company_admin')==$admin->id){{"selected"}}@endif>{{$admin->first_name . " " . $admin->last_name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <button type="button" name="add" id="add" class="btn btn-success" onclick="addMoreAdmins()"><i class="fa fa-plus"></i></button>
        </div>
        <div id="newAdmin">
            
        </div>
        @elseif(isAdmin())
        <input type="hidden" name="company_admin" id="company_admin" value="{{$user->id}}" />
        @endif

        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Company Name
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="company_name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('company_name')) parsley-error @endif" name="company_name" value="{{old('company_name')}}" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="EIN" >
                EIN
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="EIN" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('EIN')) parsley-error @endif" name="EIN" value="{{old('EIN')}}" >

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Email
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('email')) parsley-error @endif"
                       name="email" value="{{old('email')}}" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Phone
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="phone" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('phone')) parsley-error @endif"
                       name="phone" value="{{old('phone')}}"  maxlength="12">

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Address
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="address" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('address')) parsley-error @endif"
                       name="address" value="{{old('address')}}" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city" >
                City
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="city" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('city')) parsley-error @endif"
                       name="city" value="{{old('city')}}" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state" >
                State
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="state" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('state')) parsley-error @endif"
                       name="state" value="{{old('state')}}" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="zipcode" >
                Zipcode
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="zipcode" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('zipcode')) parsley-error @endif" name="zipcode" value="{{old('zipcode')}}" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="accept_payments" >
                Accept Payment
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="accept_payments" id="accept_payments"  class="form-control @if($errors->has('accept_payments')) parsley-error @endif">
                    <option value="yes" @if(old('accept_payments')=="yes"){{"selected"}}@endif>Yes</option>
                    <option value="no" @if(old('accept_payments')=="no"){{"selected"}}@endif>No</option>
                </select>
            </div>
        </div>

        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_endpoint" >
                API Endpoint
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="api_endpoint" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('api_endpoint')) parsley-error @endif" name="api_endpoint" value="{{old('api_endpoint')}}" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_key" >
                API Key
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="api_key" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('api_key')) parsley-error @endif" name="api_key" value="{{old('api_key')}}" >

            </div>
        </div>



        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_user" >
                API User
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="api_user" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('api_user')) parsley-error @endif" name="api_user" value="{{old('api_user')}}" >

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_password" >
                API Password
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="api_password" type="password" class="form-control col-md-7 col-xs-12 @if($errors->has('api_password')) parsley-error @endif" name="api_password" value="{{old('api_password')}}" >

            </div>
        </div>


        <div class="text-center"> 
            <button class="btn btn-dark text-white" > Add </button>
            <a href="{{ URL::previous() }}"><button class="btn btn-dark text-white" type="button" > Cancel </button></a>
        </div>




        {{ Form::close() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    var count = 0;
    var CompanySettingList = '{{ route('admin.company') }}';
    function addMoreAdmins(){
       // alert('usama');
       
        const par = document.createElement('div');
        par.setAttribute("id", `child${count}`)
        par.innerHTML =  `<label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_admin" >Company Admin<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="company_admin[]" id="company_admin"  class="form-control @if($errors->has('company_admin')) parsley-error @endif">
                    <option value="" @if(old('company_admin')==""){{"selected"}}@endif>-- Select Company Admin --</option>
                    @if(!empty($company_data))
                    @foreach($company_data as $admin)
                    <option onchange="captureID()" value="{{$admin->id}}" @if(old('company_admin')==$admin->id){{"selected"}}@endif>{{$admin->first_name . " " . $admin->last_name}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <button type="button" name="add" id="add" class="btn btn-success" onclick="remove(child`+count +`)"><i class="fa fa-minus"></i></button>`
            var adminMore= document.getElementById('newAdmin').appendChild(par);
            count ++ 
    }
    function captureID(){
        alert('usama');

    }
    function remove(id){
        const asd = id.getAttribute('id')
        const nested_div = document.getElementById(asd) 
        var removeDrop =  document.getElementById('newAdmin')
        removeDrop.removeChild(nested_div);
        }
</script>
@parent
{{ Html::script('assets/admin/js/company/add.js') }}
@endsection
