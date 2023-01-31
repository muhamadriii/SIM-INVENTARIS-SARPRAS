<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(User $model){
        $this->model    = $model;
        $this->view     = "profile";
        $this->path     = "admin";
        $this->route    = "admin.profile";
        View::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('route', $this->route);
    }

    public function index()
    {
        // View::share('breadcrumbs', [
        //     [$this->title, route($this->route.'.index')],
        // ]);
        $user = Auth::user();
        return view("pages.".$this->path.".".$this->view.'.index', compact('user'));
    }

    public function update(Request $request)
    {
        $req = $request->all();
        $user = $this->model->find(Auth::user()->id);

        if (!empty($req['password'])) {
            $req['password'] = Hash::make($req['password']);
        } else {
            unset($req['password']);
        }

        $img = $request->file('image');
        $image = $user['image'];

        if (!is_null($img)) {
            $destination_path = 'public/images/user';
            $image_name = date('YmdHi') . '.' . $img->getClientOriginalExtension();
            $path = $request->file('image')->storeAs($destination_path, $image_name);

            $req['image'] = $image_name;

        }else{
            $req['image'] = $image;
        }

        $user->update($req);

        return redirect()->back();
    }

}
