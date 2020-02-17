<?php

namespace FDA\Http\Controllers\User;

use FDA\Http\Controllers\Controller;
use FDA\User;
use FDA\Mail\VerifyMail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use FDA\Nrc;


class AuthController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Request $request)
    {
        return view('users.user-login');
    }

    public function showSignUpForm(Request $request)
    {
        $nrcs = DB::table('nrcs')
            ->select(DB::raw('count(*) as row_count, state_number'))
            ->groupBy('state_number')
            ->get();
        return view('users.user-signup', compact('nrcs'));
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->sendFailedLoginResponse($request);
        }

        if ($user->role === 99) {

            if ($user->is_active === 1) {
                if (auth()->attempt(['email' => request('email'), 'password' => request('password')])) {
                    
                    //only login one device per account
                    $previous_session = $user->session_id;
                    if ($previous_session) {
                        \Session::getHandler()->destroy($previous_session);
                        Auth::user()->session_id = \Session::getId();
                        Auth::user()->save();
                        return redirect()->intended(route('/'))->with('warning', "Login Success, but that will be logout other device.");
                    }

                    Auth::user()->session_id = \Session::getId();
                    Auth::user()->save();
                    return redirect()->intended(route('/'))->with('success', "Successfully Login.");
                }
            }

            return $this->sendFailedLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }


    public function logout(Request $request)
    {
        //delete current session data that save on db
        Auth::user()->session_id = null;
        Auth::user()->save();

        $this->guard()->logout();

        $request->session()->invalidate();


        return redirect()->route('user-login');
    }

    public function register(Request $request)
    {
        $validator = $this->validate($request, [
            'email' => ['required', 'string', 'unique:users'],
            'company_registration_no' => ['required', 'digits:9', 'unique:users'],
            'company_phone_no' => ['required', 'digits_between:6,11'],
            'applicant_phone_no' => ['required', 'digits_between:6,11'],
            'name' => 'required|string',
            'applicant_name' => 'required',
            'g-recaptcha-response' => 'required|captcha'

        ]);
        if ($validator) {
            $str_pass = str_random(8);
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($str_pass),
                'company_name' => $request['company_name'],
                'company_phone_no' => $request['company_phone_no'],
                'company_registration_no' => $request['company_registration_no'],
                'applicant_name' => $request['applicant_name'],
                'applicant_phone_no' => $request['applicant_phone_no'],
                'role' => 99,
                'applicant_nrc' => $request['state_number'] . "/" . $request['city_name'] . "(" . $request['nationality_type'] . ")" . $request['nrcno'],
                'registration_date' => now(),
            ]);

            // $users = $this->create($input)->toArray();
            $user['link'] = str_random(30);
            DB::table('users_activation')->insert([
                'user_id' => $user['id'],
                'token' => $user['link']
            ]);
            Mail::to($user->email)->send(new VerifyMail($user, $str_pass));
            return redirect()->to('user-login')->with('success', "We Send Activation Code to the {$user['email']}, Please Check this email(if not found, check spam mail)");
        }
        return back()->with('Error', $validator->errors());
    }

    public function userActivation($token)
    {
        $check = DB::table('users_activation')->where('token', $token)->first();
        if (!is_null($check)) {
            $user = User::find($check->user_id);
            if ($user->is_active == 1) {
                return redirect()->to('user-login')->with('warning', "You are already activated")->withInput();
            }

            $user->is_active = 1; //change the status
            $user->save();
            Auth::loginUsingId($user->id); //login the user using the user id
            return redirect()->to('user-login')->with('success', "Successfully activated");
        }
        return redirect()->to('user-login')->with('warning', "Your token is invalid");
    }

    public function updateResetPw(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (empty($user)) {
            return back()->with('error', 'The requested email does not exist.');
        }elseif($user->is_active == 0){
            return back()->with('error', 'The requested email does not verify yet.');
        }else {
            // generate password and send password
            $str_pass = str_random(8);
            $user->update([
                'password' => bcrypt($str_pass),
            ]);
            Mail::to($user->email)->send(new VerifyMail($user, $str_pass));
            return redirect()->to('forgot-password')->with('success', 'Please check your email, we have sent the reset password to your '.$request->email);
        }
    }

    public function cityNameAjax(Request $request)
    {
        $cityNames = Nrc::select('short_district_mm')->where('state_number', $request->state_number)->get();
        return response()->json($cityNames);
    }
}
