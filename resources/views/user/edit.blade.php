@extends('layouts.app')
@section('title', 'Profile')
@section('css')

@endsection
@section('js')

@endsection
@section('content')
    {{Form::open(['route' => 'user.update'])}}
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
        <div class="col-lg-5 col-xs-12">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        {{Form::label('email', 'Email')}}
                        <p><input type="text" class="form-control" disabled="disabled" value="{{Auth::user()->email}}" id="email"></p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        {{Form::label('name', 'Name')}}
                        {{Form::text('name', Auth::user()->name, ['class' => 'form-control'])}}
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12">
            {{Form::submit('Update', ['class' => 'btn btn-outline-primary'])}}
        </div>

    </div>
    {{Form::close()}}

@endsection
