@extends('layouts.app')

@section('body_class','nav-md')
@include('admin.layouts.flash-messages')
@section('page')
    <div class="container body">
        <div class="main_container">
            @section('header')
                @include('admin.sections.navigation')
                @include('admin.sections.header')
            @show

            @yield('left-sidebar')

            <div class="right_col" role="main">
                <div class="page-title">
                    <div class="title_left">
                        <h1 class="h3">@yield('title')</h1>
                    </div>
                    @if(Breadcrumbs::exists())
                        <div class="title_right">
                            <div class="pull-right">
                                {!! Breadcrumbs::render() !!}
                            </div>
                        </div>
                    @endif
                </div>
                @yield('content')
            </div>

            <footer>
                @include('admin.sections.footer')
            </footer>
        </div>
    </div>
@stop

@section('styles')
    {{ Html::style(mix('assets/admin/css/admin.css')) }}
    {{ Html::style('assets/admin/css/bootstrap-datetimepicker.css') }}
    {{ Html::style('assets/admin/css/select2.min.css') }}

    <!-- {{ Html::style('assets/admin/css/jquery.dataTables1.10.16.min.css') }} -->
    {{ Html::style('assets/admin/css/dataTables.bootstrap4-1.10.19.min.css') }} 
  
@endsection

@section('scripts')
    {{ Html::script(mix('assets/admin/js/admin.js')) }}
    {{ Html::script('https://code.jquery.com/jquery-3.5.1.js') }}

    {{ Html::script('assets/admin/js/jquery.validate.min.js') }}
    {{ Html::script('assets/admin/js/moment.js') }}
    {{ Html::script('assets/admin/js/bootstrap-datetimepicker.min.js') }}
    {{ Html::script('assets/admin/js/select2.min.js') }}


    {{Html::script('assets/admin/js/jquery.dataTables-1.10.16.min.js')}}
    {{Html::script('assets/admin/js/bootstrap-4.1.3.min.js')}}
    {{Html::script('assets/admin/js/dataTables.bootstrap4-1.10.19.min.js')}}


@endsection