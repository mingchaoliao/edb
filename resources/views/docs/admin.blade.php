@extends('layouts.app')
@section('title', 'Admin Document')
@section('css')
<style>
    .container a {
        color: #0275d8 !important;
    }
</style>
@endsection
@section('js')

@endsection
@section('content')

@include('wiki.admin')

@endsection
