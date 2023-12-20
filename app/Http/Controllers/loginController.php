<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('login', 'register', 'logout', 'loginAction', 'registerUser', 'checkUsername', 'checkEmail');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function loginAction(Request $request)
    {
        try {

            // dd($request->toArray());
            $rules = [
                'email' => 'required|email',
                'password' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Please fill all mendetory feilds');
            }

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if ($user->type == 'user') {
                    if ($user->status == 'waiting') {
                        return redirect()->route('login')->with('error', 'We are currently reviewing your account. Please check back in 2-3 business days for an update.');
                    }
                    if ($user->status == 'inactive') {
                        return redirect()->route('login')->with('error', 'You account is blocked by Admin.');
                    }
                    // return redirect()->intended('/')->with('welcome', 'Mubarakho ' . $user->first_name . '! Tum is platform ka pehla user hoo.');
                    return redirect()->intended('/');
                } else {
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Credential does not match');
                }
            }
            return redirect()->route('login')->with('error', 'Credential does not match');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something went wrong ' . $err);
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect()->route('login');
    }

    public function registerUser(Request $request)
    {
        try {
            // dd($request->toArray());
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'required'
            ];
            // dd($request->toArray());

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Please fill all mendetory feilds');
            }

            $usernameFound = User::where('username', $request->username)->count();
            $emailFound = User::where('email', $request->email)->count();

            if ($usernameFound > 0) {
                return redirect()->back()->with('error', 'Username already taken');
            }

            if ($emailFound > 0) {
                return redirect()->back()->with('error', 'Email already taken');
            }

            $user = new User();
            $user->first_name = ucfirst($request->first_name) ?? '';
            $user->last_name = ucfirst($request->last_name) ?? '';
            $user->name =  ucfirst($request->first_name) . ' ' . ucfirst($request->last_name);
            $user->username = strtolower(str_replace(' ', '', $request->username)) ?? '';
            $user->email = strtolower($request->email) ?? '';
            $user->password = Hash::make($request->password);
            $user->plain_pass = $request->password ?? '';
            $user->profile_pic = '';
            $user->status = 'active';
            $user->type = 'user';
            $user->email_verified_at = Carbon::now();
            $user->save();

            $userInfo = new UserInformation();
            $userInfo->user_id = $user->id;
            $userInfo->status = 'online';
            $userInfo->save();

            if ($request->hasFile('user_image')) {
                $image = $request->file('user_image');
                $filename = $user->username . '_' . $user->id . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $mainImg = Image::make($image)->fit(400, 400);
                $thumbnailImage = Image::make($image)->fit(100, 100);
                $mainImg->save(public_path('user_profile_picture/' . $filename));
                $thumbnailImage->save(public_path('user_profile_picture/thumb/' . $filename));

                $replaceUser = User::find($user->id);
                $replaceUser->profile_pic = $filename;
                $replaceUser->save();
            }

            // return redirect()->route('login')->with('success',  $user->first_name . ', acc create ho gya ab fatak se login karo');
            return redirect()->route('login')->with('success',  $user->first_name . ', your account is successfully created please login to continue');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something went wrong ' . $err);
        }
    }

    public function checkUsername(Request $request)
    {
        try {
            $rules = [
                'username' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => '(Please Provide valid username)']);
            }

            $cleanUsername = strtolower(str_replace(' ', '', $request->username)) ?? '';

            $usernameFound = User::where('username', $cleanUsername)->count();

            if ($usernameFound > 0) {
                return response()->json(['status' => false, 'message' => '(username already taken)']);
            } else {
                return response()->json(['status' => true, 'message' => 'Username Accepted']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => '(Please try again)']);
        }
    }
    public function checkEmail(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => '(Please Provide valid email)']);
            }

            $useremailFound = User::where('email', $request->email)->count();

            if ($useremailFound > 0) {
                return response()->json(['status' => false, 'message' => '(email already taken)']);
            } else {
                return response()->json(['status' => true, 'message' => 'email Accepted']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => '(Please try again)']);
        }
    }
}
