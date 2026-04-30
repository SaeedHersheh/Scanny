<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class AuthController extends Controller
{
    

    public function showRegisterForm()
    {
        return view('auth.register');

    }

    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:6|confirmed',
        ]);

        $user = User::create([
        'name' => $request->name,
            'email' => $request->email,
            'balance' => 0,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('login.form');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required|string',
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            //boolean
            $request->session()->put('login_success',true);

            return redirect()->route('home');
        }

        

        return back()->withErrors([
            'email'=>'invalid Email',
            'password'=> ' invalid password',
        ]);

        
    }


    public function dashboard() {
        return view('dashboard');
    }



    public function logout(Request $request) 
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('Auth.login');
    }


     

}
