<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function login(){
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function attempt(Request $request){
        $this->validate($request, [
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required', 'min:6', 'max:255']
        ]);

        $credentials = $request->only(['email', 'password']);
        //return var_dump($credentials);
        $remember = $request->has('remember');
        if (!Auth::attempt($credentials, $remember)){
            return redirect()->back()
                ->with('fail', 'Credenciais não encontradas')
                ->withInput();
        }
        return redirect('dashboard');
    }

    public function create(Request $request){
        $this->validate($request, [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:6', 'max:255', 'confirmed']
        ]);

        $credentials = array_merge($request->all(), ['password' => bcrypt($request->input('password'))]);

        User::create($credentials);

        return redirect('auth/login');
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
