@extends('layouts.app')
@section('title', 'Add Species')
@section('css')

@endsection
@section('js')

@endsection
@section('content')

    {{Form::open(['route' => 'species.store'])}}
    <div class="row">
        @foreach ($schemeArr as $scheme)
            @if ($scheme->type == 'input')
                <div class="col-xl-3 col-lg-4 col-md-6 col-xs-12">
                    <div class="form-group">
                        {{Form::label($scheme->key, $scheme->displayed_name)}}
                        {{Form::text($scheme->key, '', ['class' => 'form-control'])}}
                    </div>
                </div>
            @elseif ($scheme->type == 'textarea')
                <div class="col-md-6 col-xs-12">
                    <div class="form-group">
                        {{Form::label($scheme->key, $scheme->displayed_name)}}
                        {{Form::textarea($scheme->key, '', ['class' => 'form-control'])}}
                    </div>
                </div>
            @elseif ($scheme->type == 'boolean')
                <div class="col-lg-3 col-md-4 col-xs-6">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                {{Form::label($scheme->key, $scheme->displayed_name)}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                Yes
                                {{Form::radio($scheme->key, 'TRUE')}}
                                No
                                {{Form::radio($scheme->key, 'FALSE')}}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($scheme->type == 'photo')
                <div class="col-md-6 col-xs-12">

                </div>
            @elseif ($scheme->type == 'audio')
                <div class="col-md-6 col-xs-12">

                </div>
            @else

            @endif
        @endforeach
    </div>
    {{Form::submit('Submit', ['class' => 'btn btn-default', 'style' => 'cursor: pointer;'])}}
    {{Form::close()}}

@endsection
