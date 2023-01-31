<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use View;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(User $user)
    {
        $this->middleware('can:user.list')->only('index');
        $this->middleware('can:user.create')->only('store');
        $this->middleware('can:user.update')->only('update');
        $this->middleware('can:user.delete')->only('destroy');

        $this->model    = $user;
        $this->view     = "pages.admin.users";
        $this->route    = "admin.users";
        $this->title    = "User List";
        $this->roles    = Role::all();

        View::share('route', $this->route);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
        View::share('roles', $this->roles);
    }

    public function index(UserDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        return $dataTable->render($this->view . '.index');
    }

    public function create()
    {
        $roles = User::all();
        return  to_route('', ['roles' => $roles]);
    }

    public function store(UserRequest $request , UserDataTable $dataTable)
    {
        try {
            $payload = $request->all();
            $payload['password'] = Hash::make($payload['password']);
            $payload['type'] = $payload['role'];

            if($request->file('image')) {
                $filename = $request->file('image')->getClientOriginalName();
                Storage::putFileAs(
                    'public/images',
                    $request->file('image'),
                    $filename
                );
                $payload['image'] = $filename;
            }

            $data = $this->model->create($payload);
            $data->assignRole($payload['role']);

            $response = [
                'success' => true,
                'message' => 'Success save data',
                'data' => $data
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Server Error',
                'data' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }


    public function show($id)
    {
        try {
            $data = $this->model->find($id);

            $response = [
                'success' => true,
                'message' => 'Success retrieve data',
                'data' => $data
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Server Error',
                'data' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }


    public function edit(User $user)
    {
        //
    }


    public function update(UserRequest $request, $id)
    {
        try {
            $payload = $request->all();
            $user = $this->model->find($id);

            if (!empty($payload['password'])) $payload['password'] = Hash::make($payload['password']);
            else unset($payload['password']);
            $payload['type'] = $payload['role'];

            if($request->file('image')) {
                $filename = $request->file('image')->getClientOriginalName();
                Storage::putFileAs(
                    'public/images',
                    $request->file('image'),
                    $filename
                );
                $payload['image'] = $filename;
            }

            $data = $user->update($payload);
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            $user->assignRole($payload['role']);

            $response = [
                'success' => true,
                'message' => 'Success save data',
                'data' => $data
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];
            return response()->json($response, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = $this->model->find($id);
            $data = $user->delete();

            $response = [
                'success' => true,
                'message' => 'Success delete data',
                'data' => $data
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];
            return response()->json($response, 500);
        }
    }
}
