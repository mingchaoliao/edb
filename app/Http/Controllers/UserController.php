<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$users = User::select('id', 'has_deleted', 'created_at', 'updated_at', 'email', 'name', 'is_miami', 'role_id')
			->get();

		$userRoles = [];
		foreach(Role::get()->toArray() as $role) {
			$userRoles[$role['id']] = $role['name'];
		}
		return view('user.index', ['users' => $users, 'userRoles' => $userRoles]);
    }

    /**
     * Restore deleted user
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        User::findOrFail($id)->update(["has_deleted" => 0]);
        return redirect(route('user.index'));
    }

	/**
	 * Show the form for editing user profile.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit()
	{
		return view('user.edit');
	}

	/**
	 * Update the user profile.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$data = $request->all();
		User::find(Auth::user()->id)->update(['name' => $data['name']]);

		if($data['oldPassword'] != '') {
		    if($data['password'] == '') {
                return redirect()->back()
                    ->with('password', 'new password cannot be empty');
            }
		    if(Hash::check($data['oldPassword'], Auth::user()->password)) {
                User::find(Auth::user()->id)->update(['password' => Hash::make($data['password'])]);
            } else {
                return redirect()->back()
                    ->with('oldPassword', 'old password is incorrect');
            }
        }

		return redirect(route('home.index'));
	}


    /**
     * Update role for specified user
     *
     * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request, $id)
    {
		$data = $request->all();

		User::find($id)
			->update(['role_id' => $data['role_id']]);

		return redirect(route('user.index'));
    }

	/**
	 * Remove the specified user from users table.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		User::findOrFail($id)->update(['has_deleted' => 1]);
		return redirect(route('user.index'));
	}
}
