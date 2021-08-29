@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(session()->get('flash_warning'))
<div class="alert-container">
    <div class="alert alert-warning">
        <div class="alert-icon pull-left"><i class="glyphicon glyphicon-warning-sign"></i></div>
        <div class="alert-description">
            @if(is_array(json_decode(session()->get('flash_warning'), true)))
            {!! implode('', session()->get('flash_warning')->all(':message<br/>')) !!}
            @else
            {!! session()->get('flash_warning') !!}
            @endif
        </div>
    </div>
</div>
@elseif (session()->get('flash_success'))
<div class="alert-container common-success-message">
    <div class="alert alert-success">
        <div class="alert-icon pull-left m-r-sm"><i class="glyphicon glyphicon-ok-circle"></i></div>
        <div class="alert-description">
            @if(is_array(json_decode(session()->get('flash_success'), true)))
            {!! implode('', session()->get('flash_success')->all(':message<br/>')) !!}
            @else
            {!! session()->get('flash_success') !!}
            @endif
        </div>
    </div>
</div>
@endif

@if (session()->get('flashSuccess'))
<div class="alert-container common-success-message">
    <div class="alert alert-success">
        <div class="alert-icon pull-left m-r-sm"><i class="glyphicon glyphicon-ok-circle"></i></div>
        <div class="alert-description">
            @if(is_array(json_decode(session()->get('flashSuccess'), true)))
            {!! implode('', session()->get('flashSuccess')->all(':message<br/>')) !!}
            @else
            {!! session()->get('flashSuccess') !!}
            @endif
        </div>
    </div>
</div>
@endif