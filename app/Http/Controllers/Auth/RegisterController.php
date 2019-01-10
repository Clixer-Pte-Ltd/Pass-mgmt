<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserCreated;
use Backpack\Base\app\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Validator;
use App\Events\CompanyAddAccount;

class RegisterController extends Controller
{
    protected $data = []; // the information we send to the view

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $guard = backpack_guard_name();

        // $this->middleware("guest:$guard");

        // Where to redirect users after login / registration.
        $this->redirectTo = property_exists($this, 'redirectTo') ? $this->redirectTo
            : config('backpack.base.route_prefix', 'dashboard');
    }

    /**
     * Get a validator for update account by user
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateUpdateAccountByUser(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = $user_model_fqn::where('token', $data['token'])->first();
        if (is_null($user)) {
            return false;
        }
        $users_table = $user->getTable();
        $email_validation = backpack_authentication_column() == 'email' ? 'email|' : '';

        return Validator::make($data, [
            'name' => 'required|max:255',
            backpack_authentication_column() => 'required|' . $email_validation . 'max:255|unique:' . $users_table . ',id,' . $user->email,
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|digits:8'
        ]);
    }

    /**
     * Get a validator for create account by company
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validateAddAccountByCompany(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();
        $users_table = $user->getTable();
        $email_validation = backpack_authentication_column() == 'email' ? 'email|' : '';

        return Validator::make($data, [
            'name' => 'required|max:255',
            backpack_authentication_column() => 'required|' . $email_validation . 'max:255|unique:' . $users_table
        ]);
    }

    /**
     * Save a new user account by company
     *
     * @param array $data
     *
     * @return User
     */
    protected function storeNewAccountByCompany(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();

        return $user->create([
            'name' => $data['name'],
            backpack_authentication_column() => $data[backpack_authentication_column()],
            'tenant_id' => isset($data['tenant_id']) ? $data['tenant_id'] : null,
            'sub_constructor_id' => isset($data['sub_constructor_id']) ? $data['sub_constructor_id'] : null,
            'token' => isset($data['token']) ? $data['token'] : null
        ]);
    }

    /**
     * Update account by user
     *
     * @param array $data
     *
     * @return User
     */
    protected function updateAccountByUser(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = $user_model_fqn::where('token', $data['token'])->first();
        if (is_null($user)) {
            return false;
        }

        $user->update([
            'name' => $data['name'],
            backpack_authentication_column() => $data[backpack_authentication_column()],
            'password' => bcrypt($data['password']),
            'google2fa_secret' => $data['google2fa_secret'],
            'phone' => isset($data['phone']) ? $data['phone'] : null,
            'token' => isset($data['token']) ? $data['token'] : null
        ]);
        return $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm($token = null)
    {
        // if registration is closed, deny access
        if (!config('backpack.base.registration_open')) {
            abort(403, trans('backpack::base.registration_closed'));
        }

        $this->data['title'] = trans('backpack::base.register'); // set the page title
        $this->data['token'] = $token;

        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = $user_model_fqn::where('token', $token)->first();
        $this->data['user'] = $user;

        return view('backpack::auth.register', $this->data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // if registration is closed, deny access
        if (!config('backpack.base.registration_open')) {
            abort(403, trans('backpack::base.registration_closed'));
        }

        $resultValidate = $this->validateUpdateAccountByUser($request->all())->validate();
        if (!$resultValidate) {
            \Alert::error('Error system')->flash();
            return redirect()->back();
        }
        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        // Save the registration data in an array
        $registration_data = $request->all();

        // Add the secret key to the registration data
        $registration_data['google2fa_secret'] = $google2fa->generateSecretKey();

        // Save the registration data to the user session for just the next request
        $request->session()->flash('registration_data', $registration_data);

        // Generate the QR image. This is the image the user will scan with their app
        // to set up two factor authentication
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $registration_data['email'],
            $registration_data['google2fa_secret']
        );

        // Pass the QR barcode image to our view
        return view('google2fa.register', ['QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret']]);

        // $this->guard()->login($this->create($request->all()));

        // return redirect($this->redirectPath());
    }

    /**
     * Create new account by company
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeAddAccount(Request $request)
    {
        // if registration is closed, deny access
        if (!config('backpack.base.registration_open')) {
            abort(403, trans('backpack::base.registration_closed'));
        }
        $this->validateAddAccountByCompany($request->all())->validate();

        $data = $request->all();
        $data['token'] = str_random(40);

        $user = $this->storeNewAccountByCompany($data);

        //send mail to user
        event(new CompanyAddAccount($user));

        if (session()->has(SESS_NEW_ACC_FROM_TENANT)) {
            $id = session()->get(SESS_NEW_ACC_FROM_TENANT);
            session()->forget(SESS_NEW_ACC_FROM_TENANT);

            if (session()->has(SESS_TENANT_MY_COMPANY)) {
                return redirect()->route('admin.tenant.my-company');
            }
            \Alert::success('Sended email to account')->flash();
            return redirect()->route('crud.tenant.show', [$id]);
        }

        if (session()->has(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR)) {
            $id = session()->get(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);
            session()->forget(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);
            \Alert::success('Sended email to account')->flash();
            return redirect()->route('crud.sub-constructor.show', [$id]);
        }

        return redirect()->route('backpack.dashboard');
    }

    /**
     * complete create account for user
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function completeRegistration(Request $request)
    {
        // add the session data back to the request input
        $request->merge(session('registration_data'));

        $user = $this->updateAccountByUser($request->all());

        if (!$user) {
            \Alert::error('Create account error')->flash();
            return redirect()->back();
        }

        event(new UserCreated($user));

        if (session()->has(SESS_NEW_ACC_FROM_TENANT)) {
            $id = session()->get(SESS_NEW_ACC_FROM_TENANT);
            session()->forget(SESS_NEW_ACC_FROM_TENANT);
            
            if (session()->has(SESS_TENANT_MY_COMPANY)) {
                return redirect()->route('admin.tenant.my-company');
            }
            return redirect()->route('crud.tenant.show', [$id]);
        }

        if (session()->has(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR)) {
            $id = session()->get(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);
            session()->forget(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);
            return redirect()->route('crud.sub-constructor.show', [$id]);
        }

        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return backpack_auth();
    }
}
