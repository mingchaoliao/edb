@extends('layouts.app')
@section('title', 'Warning')
@section('css')
    @yield('css')
@endsection
@section('js')
    @yield('js')
@endsection
@section('content')
    <div class="row">
        <div class="col-6 text-xs-center">
            <h1>Warning</h1>
            <h4>@yield('title')</h4>
            <div class="row">
                @yield('buttons')
            </div>
        </div>
    </div>





@endsection
