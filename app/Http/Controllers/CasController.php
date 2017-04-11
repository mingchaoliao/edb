<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class CasController extends Controller
{

    protected $cas;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cas = app('cas');
    }

    /**
     * Handle Miami Cas
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if ($this->cas->isAuthenticated()) {
            $username = $this->cas->user() . "@miamioh.edu";
            echo $username; exit();
            $user = User::where('email', $username)->first();
        } else {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }
            $this->cas->authenticate();
        }
    }
}
