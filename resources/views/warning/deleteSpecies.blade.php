@extends('layouts.warning')
@section('css')

@endsection
@section('js')

@endsection
@section('title', 'Are you sure?')
@section('buttons')


    <a href="{{route('species.destroy', ['id' => $data['id']])}}" class="btn btn-danger" onclick="event.preventDefault();
document.getElementById('destroy-species-form').submit();"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
    <form id="destroy-species-form" action="{{route('species.destroy', ['id' => $data['id']])}}" method="POST" style="display: none;">
        <input type="hidden" name="_method" value="DELETE">
        {{ csrf_field() }}
    </form>

    <a href="javascript:history.go(-1)" class="btn btn-default">Go Back</a>





@endsection
