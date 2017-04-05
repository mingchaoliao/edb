@extends('layouts.app')
@section('title', 'View')
@section('css')
    <style>
        .viewBlock {
            margin-top: 15px;
        }

        .viewBlock .row:nth-child(2) {
            padding-right: 15px;
        }

        .viewBlock .row:nth-child(2) > div {
            border: 1px solid #D8D8D8;
        }
    </style>
@endsection
@section('js')

@endsection
@section('content')
    <div class="row">
        @foreach ($schemeArr as $scheme)
            @if ($scheme->type == 'input')
                <div class="viewBlock col-xl-3 col-lg-4 col-md-6 col-xs-12">
                    <div class="row">
                        <strong>{{$scheme->name}}:</strong>
                        <span style="position: absolute; top: 0; right: 18px;">
                            <a href="{{route('species.history', ['id' => $species->id, 'key' => $scheme->key])}}"><i class="fa fa-history" aria-hidden="true"></i></a>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-12" style="height: 27px; overflow-x: auto;">
                            {{$species->getAttribute($scheme->key)}}
                        </div>
                    </div>
                </div>
            @elseif ($scheme->type == 'textarea')
                <div class="viewBlock col-md-6 col-xs-12">
                    <div class="row">
                        <strong>{{$scheme->name}}:</strong>
                        <span style="position: absolute; top: 0; right: 18px;">
                            <a href="{{route('species.history', ['id' => $species->id, 'key' => $scheme->key])}}"><i class="fa fa-history" aria-hidden="true"></i></a>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-12" style="height: 200px; overflow-y: auto;">
                            {{$species->getAttribute($scheme->key)}}
                        </div>
                    </div>
                </div>
            @elseif ($scheme->type == 'boolean')
                <div class="viewBlock col-lg-3 col-md-4 col-xs-6">
                    <div class="row">
                        <strong>{{$scheme->name}}:</strong>
                        <span style="position: absolute; top: 0; right: 18px;">
                            <a href="{{route('species.history', ['id' => $species->id, 'key' => $scheme->key])}}"><i class="fa fa-history" aria-hidden="true"></i></a>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-12" style="height: 27px;">
                            {{$species->getAttribute($scheme->key)}}
                        </div>
                    </div>
                </div>
            @elseif ($scheme->type == 'photo')
                <div class="viewBlock col-md-6 col-xs-12">

                </div>
            @elseif ($scheme->type == 'audio')
                <div class="viewBlock col-md-6 col-xs-12">

                </div>
            @else

            @endif
        @endforeach
    </div>



@endsection
