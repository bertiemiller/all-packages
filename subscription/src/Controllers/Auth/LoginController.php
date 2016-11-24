<?php

namespace Topicmine\Subscription\Controllers\Auth;

use Topicmine\Subscription\Controllers\Auth\Traits\TokenHelper;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use JWTAuth;
use Illuminate\Http\Request;
use App\Exceptions\GeneralException;

class LoginController extends Controller
{
    // Need to overide default functions so renaming them
    use AuthenticatesUsers {
        authenticated as authenticatedTrait;
        logout as logoutTrait;
    }

    // API token helper
    use TokenHelper;

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /*
     * TopicMine ammendments
     */

    protected function authenticated(Request $request, $user)
    {
        /**
         * Check to see if the users account is confirmed and active
         */
        if (! $user->isConfirmed())
        {
            request()->session()->put('subscribingUserEmail', $user->email);

            $this->logout($request);

            flash('Your account is not confirmed. Please check your inbox for a
                confirmation email or submit the form below for another to be resent.', 'warning');
            return redirect('/register/confirm');

        }
        elseif (! $user->isActive())
        {
            $this->logout($request);

            throw new GeneralException('Your account has been deactivated.');
        }

        $token = $this->authenticate($request);

        request()->session()->put('jwt.token', $token);
    }

    public function logout(Request $request)
    {
        $inputs = $request->all();

        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        if(isset($inputs['message'])) {
            flash($inputs['message'], ( isset($inputs['type']) ? $inputs['type'] : 'info') )->important();
        }

        if(isset($inputs['redirect'])) {
            return redirect($inputs['redirect']);
        }

        return redirect('/');
    }

}
