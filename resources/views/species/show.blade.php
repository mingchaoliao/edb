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
<script>
    $(document).ready(function() {
        $("#showHistoryBtn").click(function(e) {
            e.preventDefault();
            $(this).hide();
            $("#hideHistoryBtn").removeClass("btn-outline-primary");
            $("#hideHistoryBtn").addClass("btn-primary");
            $("#hideHistoryBtn").show();
            $(".historyBtn").show();

        });
        $("#hideHistoryBtn").click(function(e) {
            e.preventDefault();
            $(this).hide();
            $("#showHistoryBtn").removeClass("btn-primary");
            $("#showHistoryBtn").addClass("btn-outline-primary");
            $("#showHistoryBtn").show();
            $(".historyBtn").hide();
        });
    });
</script>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <a href="#" id="showHistoryBtn" class="no-loading btn btn-outline-primary float-right" style="margin-left: 15px;">Show History Buttons</a>
            <a href="#" id="hideHistoryBtn" class="no-loading btn btn-outline-primary float-right" style="margin-left: 15px; display: none;">Hide History Buttons</a>
            <a href="{{route('species.edit', ['id' => $species->id])}}" class="float-right btn btn-outline-primary">Edit This Species</a>
        </div>
        <div class="col-12">
            <p style="text-align: right; margin: 0; color: gray;">Version: {{$species->version}} </p>
            <p style="text-align: right; margin: 0; color: gray;">Created By: {{\App\User::find($species->user_id)->name}}</p>
            <p style="text-align: right; margin: 0; color: gray;">Created At: {{$species->created_at}}</p>
            @if(!$species->is_approved)
                <p style="text-align: right; margin: 0; color: #941728;">This version hasn't been approved</p>
            @endif
        </div>
    </div>
    <div class="row">
        @foreach ($schemeArr as $scheme)
            @if ($scheme->type == 'input')
                <div class="viewBlock col-xl-3 col-lg-4 col-md-6 col-xs-12">
                    <div class="row">
                        <strong>{{$scheme->name}}:</strong>
                        <span style="position: absolute; top: 0; right: 18px;">
                            <a class="historyBtn" style="display: none;" href="{{route('species.history', ['id' => $species->id, 'key' => $scheme->key])}}"><i class="fa fa-history" aria-hidden="true"></i></a>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-12" style="min-height: 27px;">
                            {{$species->getAttribute($scheme->key)}}
                        </div>
                    </div>
                </div>
            @elseif ($scheme->type == 'textarea')
                <div class="viewBlock col-md-6 col-xs-12">
                    <div class="row">
                        <strong>{{$scheme->name}}:</strong>
                        <span style="position: absolute; top: 0; right: 18px;">
                            <a class="historyBtn" style="display: none;" href="{{route('species.history', ['id' => $species->id, 'key' => $scheme->key])}}"><i class="fa fa-history" aria-hidden="true"></i></a>
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
                            <a class="historyBtn" style="display: none;" href="{{route('species.history', ['id' => $species->id, 'key' => $scheme->key])}}"><i class="fa fa-history" aria-hidden="true"></i></a>
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
                    <div class="row">
                        <strong>{{$scheme->name}}:</strong>
                        <span style="position: absolute; top: 0; right: 18px;">
                            <a class="historyBtn" style="display: none;" href="{{route('species.history', ['id' => $species->id, 'key' => $scheme->key])}}"><i class="fa fa-history" aria-hidden="true"></i></a>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-12" style="padding: 15px;">
                            @if($photoUrl)
                                <a href="{{$photoUrl}}" target="_blank"><img src="{{$photoUrl}}" alt="photo" style="width: 100%;"></a>
                            @else
                                No Photo !
                            @endif
                        </div>
                    </div>

                </div>
            @elseif ($scheme->type == 'audio')
                <div class="viewBlock col-md-6 col-xs-12">
                    <div class="row">
                        <strong>{{$scheme->name}}:</strong>
                        <span style="position: absolute; top: 0; right: 18px;">
                            <a class="historyBtn" style="display: none;" href="{{route('species.history', ['id' => $species->id, 'key' => $scheme->key])}}"><i class="fa fa-history" aria-hidden="true"></i></a>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @if($audioUrl)
                                <audio controls>
                                    <source src="{{$audioUrl}}">
                                    Your browser does not support the audio tag.
                                </audio>
                            @else
                                No Audio !
                            @endif
                        </div>
                    </div>
                </div>
            @else

            @endif
        @endforeach
    </div>



@endsection
