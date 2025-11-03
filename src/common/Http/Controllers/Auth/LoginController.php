<?php

namespace Lara\Common\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use Lara\Front\Http\Concerns\hasFrontend;

use Lara\Common\Lara\UsersEntity;

use stdClass;

class LoginController extends Controller
{
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

    use AuthenticatesUsers;
	use hasFrontend;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');

	    $this->entity = new UsersEntity();

	    $this->data = new stdClass();
    }

	public function showLoginForm()
	{
		return view('_user.auth.login', [
			'data' => $this->data,
		]);
	}

	/**
	 *
	 * Override credentials
	 *
	 * Get the needed authorization credentials from the request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	protected function credentials(Request $request)
	{
		$field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
			? $this->username()
			: 'name';

		return [
			$field     => $request->get($this->username()),
			'password' => $request->password,
		];
	}


}
