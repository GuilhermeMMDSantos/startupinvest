@extends('../layout')
@section('stylesheets')
@yield('stylesheets_admin')
@endsection

@section('contentBody')
<div>
    @include('Admin.header_admin')
    @yield('contentBody_admin')

</div>
@include('Admin.footerMobile_admin')
@endsection
@section('scripts')
@yield('scripts_admin')
@endsection