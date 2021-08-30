@extends('layout')
@section('stylesheets')
@yield('stylesheets_base_inicio')
@endsection

@section('contentBody')
<div>
    @include('includes/header')
    @yield('contentBody_base_inicio')

</div>
@include('includes.footerMobile')
@endsection
@section('scripts')
@yield('scripts_base_inicio')
@endsection