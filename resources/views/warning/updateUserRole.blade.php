@extends('layouts.warning')
@section('css')

@endsection
@section('js')

@endsection
@section('title', 'Are you sure?')
@section('buttons')


    <a href="{{route('user.update.role', ['id' => $data['id'], 'role_id' => $data['role_id']])}}" class="btn btn-danger" onclick="event.preventDefault();
document.getElementById('update-user-role-form').submit();"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
    <form id="update-user-role-form" action="{{route('user.update.role', ['id' => $data['id'], 'role_id' => $data['role_id']])}}" method="POST" style="display: none;">
        <input type="hidden" name="_method" value="PUT">
        {{ csrf_field() }}
    </form>

    <a href="javascript:history.go(-1)" class="btn btn-default">Go Back</a>





@endsection
