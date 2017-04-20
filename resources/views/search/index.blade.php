@extends('layouts.app')
@section('title', 'Advanced Search')
@section('css')

@endsection
@section('js')
    <script>
        function objectifyForm(formArray) {//serialize data function

            var returnArray = {};
            for (var i = 0; i < formArray.length; i++){
                returnArray[formArray[i]['name']] = formArray[i]['value'];
            }
            return returnArray;
        }

        $('#advancedSearchBtn').click(function(e) {
            e.preventDefault();


            window.location.href = "{{route('search.result')}}?type=advancedSearch&q=" + JSON.stringify(objectifyForm($('#advancedSearchForm').serializeArray()));
        });
    </script>
@endsection
@section('content')

    {{Form::open(['route' => 'species.store', 'id' => 'advancedSearchForm'])}}
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
                                {{Form::radio($scheme->key, 'FALSE', false)}}
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
    <a href="#" class="btn btn-primary" id="advancedSearchBtn">Search</a>
    {{Form::close()}}
@endsection
