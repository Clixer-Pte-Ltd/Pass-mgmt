<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserCreated;
use Backpack\Base\app\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Validator;
use App\Events\CompanyAddAccount;
use App\Models\BackpackUser;

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
        $userToken = BackpackUser::where('token', $token)->first();
        if (is_null($token) || is_null($userToken)) {
            abort(404);
        }
        $this->data['title'] = trans('backpack::base.register'); // set the page title
        $this->data['token'] = $token;

        $user_model_fqn = config('backpack.base.user_model_fqn');

        $account = !is_null($token) ? $user_model_fqn::where('token', $token)->first() : null;

        $this->data['account'] = $account;

        return view('backpack::auth.register', $this->data);
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
            backpack_authentication_column() => 'required|' . $email_validation . 'max:255|unique:' . $users_table,
            'phone' => 'digits:8'
        ]);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorNewAccount(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = $data['token'] ? $user_model_fqn::where('token', $data['token'])->first() : null;
        $users_table = 'users';
        $email_validation = backpack_authentication_column() == 'email' ? 'email|' : '';
        $email_validation = $user ? 'required|' . $email_validation . 'max:255|unique:' . $users_table .',email,' . @$user->id
            : 'required|' . $email_validation . 'max:255|unique:' . $users_table .',email';
        return Validator::make($data, [
            'name' => 'required|max:255',
            backpack_authentication_column() => $email_validation,
            'password' => 'required|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'password_confirmation' => 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'phone' => 'required|digits:8'
        ], [
            'password.regex' => 'New password must contain minimum 8 characters with 1 uppercase and lowercase, 1 symbol and 1 number',
            'password_confirmation.regex' => 'New password must contain minimum 8 characters with 1 uppercase and lowercase, 1 symbol and 1 number'
        ]);
    }

    /**
     * Get a validator for create account by company
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function create(array $data, $user = null)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        unset($data['_token']);
        $data['password'] = isset($data['password']) ? $data['password'] : null;
        return $user_model_fqn::updateOrCreate(['token' => $data['token']], $data);
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
        $registration_data = $request->all();
        $this->validatorNewAccount($registration_data)->validate();

        if (!isset($registration_data['token'])) {
            $registration_data['token'] = uniqid() . str_random(40);
        }
        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

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
    public function addAccount(Request $request)
    {
        // if registration is closed, deny access
        if (!config('backpack.base.registration_open')) {
            abort(403, trans('backpack::base.registration_closed'));
        }
        $this->validateAddAccountByCompany($request->all())->validate();

        $data = $request->all();
        $data['token'] = uniqid() . str_random(40);
        if ($request->role == COMPANY_AS_ROLE_ID && isset($data['tenant_id'])) {
            $companyId = $data['tenant_id'];
            unset($data['tenant_id']);
        }
        $data['change_first_pass_done'] = 1;
        $user = $this->create($data);
        if (isset($companyId)) {
            $user->tenantsOfAs()->attach($companyId);
        }
        $user->assignRole($request->role);

        //send mail to user
        event(new CompanyAddAccount($user));
        activity()->performedOn($user)->withProperties(['name' => $user->name, 'email' => $user->email])->log('added-account');

        if (session()->has(SESS_TENANT_MY_COMPANY)) {
            session()->forget(SESS_NEW_ACC_FROM_TENANT);
            session()->forget(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);
            \Alert::success('Sent email to account')->flash();
            return redirect()->route('admin.tenant.my-company');
        }

        if (session()->has(SESS_NEW_ACC_FROM_TENANT)) {
            $id = session()->get(SESS_NEW_ACC_FROM_TENANT);
            session()->forget(SESS_NEW_ACC_FROM_TENANT);

            if (session()->has(SESS_TENANT_MY_COMPANY)) {
                return redirect()->route('admin.tenant.my-company');
            }
            \Alert::success('Sent email to account')->flash();
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
        try {
            // add the session data back to the request input
            $request->merge(session('registration_data'));

            $user = $this->create($request->all());

            if (!$user) {
                \Alert::error('Create account error')->flash();
                return redirect()->back();
            }

            if (session()->has(SESS_NEW_ACC_FROM_TENANT)) {
                $id = session()->get(SESS_NEW_ACC_FROM_TENANT);
                session()->forget(SESS_NEW_ACC_FROM_TENANT);

                if (session()->has(SESS_TENANT_MY_COMPANY)) {
                    return redirect()->route('admin.tenant.my-company');
                }
                return redirect()->route('crud.tenant.show', [$id]);
            }

            if (session()->has(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR)) {
                if (!backpack_user()->hasAnyRole(config('backpack.cag.roles'))) {
                    return redirect()->route('admin.tenant.my-company');
                }
                $id = session()->get(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);
                session()->forget(SESS_NEW_ACC_FROM_SUB_CONSTRUCTOR);
                return redirect()->route('crud.sub-constructor.show', [$id]);
            }
            $user->update(['token' => uniqid() . str_random(40)]);
            $this->guard()->login($user);

            return redirect($this->redirectPath());
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return backpack_auth();
    }

    public function showVerifyQuestions($token)
    {
        $user = BackpackUser::where('token', $token)->first();
        if (is_null($user)) {
            abort(404);
        }
        $role = $user->roles->first();
        $roleName = $role ? $role->name : 'no_role';
        if ($roleName == COMPANY_VIEWER_ROLE) {
            return redirect()->route('backpack.auth.register', ['token' => $token]);
        }
        $roleName = str_replace(' ', '_', $roleName);
        $questions = config("backpack.company.verify_questions.{$roleName}", []);
        return view('vendor.backpack.auth.verify_questions', compact('token', 'questions'));
    }

    public function verifyQuestions(Request $request)
    {
        $this->validate($request, ['verify_questions_value' => 'required|in:1'], ['verify_questions_value.required' => 'You must confirm the questions']);
        return redirect()->route('backpack.auth.register',['token' => urlencode($request->token)]);
    }
}
