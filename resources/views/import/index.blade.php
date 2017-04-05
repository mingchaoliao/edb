@extends('layouts.app')
@section('title', 'Import')
@section('css')

@endsection
@section('js')

@endsection
@section('content')

<div class="row">
    <div class="col-12">
        {{ Form::open(['route' => 'import.upload', 'files' => 'true']) }}
            {{ Form::file('importFile', ['id' => 'importFile']) }}
            {{Form::submit('Upload')}}
        {{ Form::close() }}
    </div>
</div>




@endsection
