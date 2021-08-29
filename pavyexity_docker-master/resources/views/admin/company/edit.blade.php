@extends('admin.layouts.admin')
@section('title', 'Edit Company')
@section('content')
<div class="row">
    <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2 card" style="padding-top: 12px;">
        {{ Form::open(['route'=>['admin.company.update', $company->id],'method' => 'post','class'=>'form-horizontal form-label-left','name' => "frmcompany"]) }}
        @if(isSuperAdmin())
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_admin" >Company Admin<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            @foreach($decoded_id as $d)
                <select name="company_admin[]" id="company_admin" class="form-control @if($errors->has('company_admin')) parsley-error @endif">
                    <option value="" @if(old('company_admin')==""){{"selected"}}@endif>-- Select Company Admin --</option>
                    @if(!empty($company_data))
                    @foreach($company_data as $admin)
                    <option value="{{$admin->id}}" @if(!empty($company->user_id) && $d==$admin->id){{"selected"}}@elseif(old('company_admin')==$admin->id){{"selected"}}@endif>{{$admin->first_name . " " . $admin->last_name}}</option>
                    @endforeach
                    @endif
                </select>
                @endforeach
            </div>
            <button type="button" name="add" id="add" class="btn btn-success" onclick="addMoreAdmins()"><i class="fa fa-plus"></i></button>
        </div>
        <div id="newAdmin">
            
        </div>
        @elseif(isAdmin())
        <input type="hidden" name="company_admin[]" id="company_admin" value="{{$user->id}}" />
        @endif

        <div class="form-group">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Company Name
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="company_name" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif"
                name="company_name" value="{{$company->company_name}}" >
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="EIN" >
                EIN
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="EIN" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('EIN')) parsley-error @endif" name="EIN" value="{{$company->EIN}}" >

            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Email
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif"
                name="email" value="{{$company->email}}" >
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Phone
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="phone" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif"
                name="phone" value="{{$company->phone}}" >
                @if($errors->has('phone'))
                <ul class="parsley-errors-list filled">
                    @foreach($errors->get('name') as $error)
                    <li class="parsley-required">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>


        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Address
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="address" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif"
                name="address" value="{{$company->address}}" >
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="city" >
                City
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="city" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('city')) parsley-error @endif"
                name="city" value="{{$company->city}}" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="state" >
                State
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="state" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('state')) parsley-error @endif"
                name="state" value="{{$company->state}}" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="zipcode" >
                Zipcode
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="zipcode" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('zipcode')) parsley-error @endif" name="zipcode" value="{{$company->zipcode}}" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="accept_payments" >
                Accept Payment
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="accept_payments" id="accept_payments" required class="form-control @if($errors->has('accept_payments')) parsley-error @endif">
                    <option value="yes" @if($company->accept_payments=="yes"){{"selected"}}@endif>Yes</option>
                    <option value="no" @if($company->accept_payments=="no"){{"selected"}}@endif>No</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_key" >
                API Endpoint
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="api_endpoint" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('api_endpoint')) parsley-error @endif" name="api_endpoint" value="{{$company->api_endpoint}}" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_key" >
                API Key
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="api_key" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('api_key')) parsley-error @endif" name="api_key" value="{{$company->api_key}}" >

            </div>
        </div>



        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_user" >
                API User
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="api_user" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('api_user')) parsley-error @endif" name="api_user" value="{{$company->api_user}}" >

            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_password" >
                API Password
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="api_password" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('api_password')) parsley-error @endif" name="api_password" value="{{$company->api_password}}" >

            </div>
        </div>
        <!-- <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="api_user" >
                Fix Payment Amount
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="global_link" type="text" class="form-control col-md-7 col-xs-12 @if($errors->has('global_link')) parsley-error @endif" name="global_link" value="{{$company->global_link}}" >

            </div>
        </div> -->

        <div class="form-group hide">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Global Payment Link Fix Amount
                <span class="required">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12 " id="myInput" value="{{$global_link_fix}}" readonly="">
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <button class="btn btn-dark text-white clickCopy" data-id="myInput" > Copy Link </button>
            </div>
        </div>

        <div class="form-group hide">

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                Global Payment Link 
                <span class="required">*</span>
            </label>
            <div class="col-md-5 col-sm-5 col-xs-12">
                <input type="text" class="form-control col-md-7 col-xs-12 " id="global_link_text" value="{{$global_link}}" readonly="">
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <button class="btn btn-dark text-white clickCopy" data-id="global_link_text" > Copy Link </button>
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
    var count = 0;
    var CompanySettingList = '{{ route('admin.company') }}';
    function addMoreAdmins(){
        //alert('usama');
       
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
    var CompanySettingList = '{{ route('admin.company') }}';

    $(".clickCopy").click(function(event) {
      event.preventDefault();
      var  id = $(this).data('id')
      var copyText = document.getElementById(id);
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
  });
</script>
@parent
{{ Html::script('assets/admin/js/company/add.js') }}
@endsection
