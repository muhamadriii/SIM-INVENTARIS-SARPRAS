<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $model;
    protected $view;
    protected $path;

    public function __construct(User $user){
        $this->path     = 'admin';
        $this->model    = $user;
        $this->view     = "auth";
    }

    public function index()
    {
        return  view('pages.'.$this->path.".".$this->view . ".login");
    }


    public function login(LoginRequest $request)
    {
        $input = $request->all();
        unset($input['_token']);
        if (Auth::attempt($input)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }


    public function edit(User $user)
    {
        //
    }


    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
