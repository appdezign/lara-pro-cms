<?php

namespace Lara\Common\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Lara\Common\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
	        'firstname' => 'required|string|max:255',
	        'lastname' => 'required|string|max:255',
	        'email' => 'required|string|email|max:255|unique:lara_auth_users',
	        'password' => 'required|string|min:6|confirmed',
        ]);
    }

	public function showRegistrationForm()
	{
		if(config('lara.auth.can_register')) {
			return view('_user.auth.register');
		} else {
			return redirect()->route('special.home.show');
		}

	}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Lara\Common\Models\User
     */
	protected function create(array $data)
    {

	    $fullname = $data['firstname'] . ' ';
	    if($data['middlename']) {
		    $fullname .= $data['middlename'] . ' ';
	    }
	    $fullname .= $data['lastname'];

	    // the password is encrypted in the model !!!
	    $newUser = User::create([
	        'type' => 'web',
	        'is_admin' => 0,
	        'name' => $fullname,
	        'firstname' => $data['firstname'],
	        'middlename' => $data['middlename'],
	        'lastname' => $data['lastname'],
	        'username' => $data['email'],
	        'email' => $data['email'],
	        'password' => $data['password'],
	        'locale' => 'nl',
	        'email_verified_at' => null,
        ]);

	    // assign default role
	    $role = Role::where('has_panel_access', 0)->orderby('level', 'asc')->first();
	    if($role) {
		    $newUser->assignRole($role->name);
	    }

	    return $newUser;

    }
}
