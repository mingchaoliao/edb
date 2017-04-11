<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class MiamiCASAuth
{
    protected $auth;
    protected $cas;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->cas = app('cas');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->cas->isAuthenticated()) {
            // Store the user credentials in a Laravel managed session
            session()->put('cas_user', $this->cas->user());

            $identification = Identification::where('spriden_id', strtoupper(session()->get('cas_user')))->first();

            session()->put('cas_user_pidm', $identification->spriden_pidm ?? '');

            $cohort = Cohort::findByPidm(session()->get('cas_user_pidm'));
            $student = Student::findByPidm(session()->get('cas_user_pidm'));

            session()->put('cas_user_cohort', $cohort->sgrchrt_chrt_code ?? '');
            session()->put('cas_user_campus', $student->sgbstdn_camp_code ?? '');

            return redirect()->intended();
        } else {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            }
            $this->cas->authenticate();
        }

        return $next($request);
    }
}
