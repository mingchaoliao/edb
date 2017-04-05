@extends('layouts.app')
@section('title', 'User Management')
@section('css')

@endsection
@section('js')
    <script>
        $( document ).ready(function() {
            $('.user_role_id').change(function(e) {
                $(this).parent().parent().find(".saveBtn").show();
            });
            {{--$('.saveBtn').click(function(e) {--}}
                {{--$('#modal #modalSubmitBtn').attr('data-user-id', $($(this).parent().parent().parent().find('.user-id')[0]).text());--}}
                {{--$('#modal #modalSubmitBtn').attr('data-user-role-id', $($(this).parent().parent().parent().find('.user_role_id')[0]).val());--}}
                {{--$('#modal #modalSubmitBtn').attr('data-type', 'changeUserRole');--}}
                {{--$('#modal').modal('show');--}}
            {{--});--}}
            {{--$('.deleteBtn').click(function(e) {--}}
                {{--$('#modal #modalSubmitBtn').attr('data-user-id', $($(this).parent().parent().parent().find('.user-id')[0]).text());--}}
                {{--$('#modal #modalSubmitBtn').attr('data-type', 'deleteUser');--}}
                {{--$('#modal').modal('show');--}}
            {{--});--}}
            {{--$('#modalSubmitBtn').click(function(e) {--}}
                {{--var user_id = $(this).attr('data-user-id');--}}
                {{--var user_role_id = $(this).attr('data-user-role-id');--}}
                {{--var type = $(this).attr('data-type');--}}
                {{--if(type == 'changeUserRole') {--}}
                    {{--$(document.body).append($('{{Form::open(['url' => '/user/editRole', 'method' => 'put'])}}' +--}}
                            {{--'{{Form::token()}}' +--}}
                            {{--'<input type="hidden" name="user_id" value="' + user_id + '">' +--}}
                            {{--'<input type="hidden" name="role_id" value="' + user_role_id + '">' +--}}
                            {{--'</form>'));--}}
                {{--} else if(type == 'deleteUser') {--}}
                    {{--$(document.body).append($('{{Form::open(['url' => '/userManagement/deleteUser', 'method' => 'delete', 'id' => 'tempForm'])}}' +--}}
                            {{--'{{Form::token()}}' +--}}
                            {{--'<input type="hidden" name="user_id" value="' + user_id + '">' +--}}
                            {{--'</form>'));--}}
                {{--}--}}
                {{--$('#tempForm').submit();--}}

            {{--});--}}
        });
    </script>
@endsection
@section('content')
    {{--<div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirmModal" aria-hidden="true">--}}
        {{--<div class="modal-dialog modal-sm">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<h5 class="modal-title">Warning</h5>--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                        {{--<span aria-hidden="true">&times;</span>--}}
                    {{--</button>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--Are you sure?--}}
                {{--</div>--}}
                {{--<div class="modal-footer">--}}
                    {{--<button id='modalSubmitBtn' type="button" class="btn btn-danger" data-user-id="-1" data-user-role-id="-1" data-type="-1">Confirm</button>--}}
                    {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{Form::open(['route' => ['user.update.role', 0]])}}
    <input type="hidden" name="_method" value="PUT">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>UID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Account Type</th>
            <th>Create Date</th>
            <th>Update Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <th scope="row" class="user-id">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    {{Form::select('role_id', $userRoles, $user->role_id, ['class' => 'user_role_id'])}}

                </td>
                <td>
                    @if ($user->is_miami == 1)
                        Miami SSO
                    @elseif ($user->is_google == 1)
                        Google SSO
                    @else
                        Email/Password
                    @endif
                </td>
                <td>{{$user->created_at}}</td>
                <td>{{$user->updated_at}}</td>
                <td>
                    <div class="btn-group" role="group" aria-label="Action Button Group">
                        <button type="button" onclick="event.preventDefault(); showWarningBox('updateUserRole', {id: '{{$user->id}}', role_id: $($(this).parent().parent().parent().find('.user_role_id')[0]).val()});" class="saveBtn btn btn-outline-primary" style="display: none;">Save</button>
                        <button type="button" onclick="event.preventDefault(); showWarningBox('destroyUser', {id: '{{$user->id}}'});" class="deleteBtn btn btn-outline-danger">Delete</button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{Form::close()}}





@endsection
