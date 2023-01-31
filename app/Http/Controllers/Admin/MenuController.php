<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MenuDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use Spatie\Permission\Models\Role;
use App\Models\Menu;
use App\Models\Permission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use View;

class MenuController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Menu $user)
    {
        $this->model    = $user;
        $this->view     = "pages.admin.menu";
        $this->route    = "admin.users";
        $this->title    = "Menu Management";

        View::share('route', $this->route);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
        View::share('parents', Menu::whereNull('parent_id')->get());
        View::share('permissions', Permission::orderby('name', 'asc')->get());
    }

    public function index(MenuDataTable $dataTable)
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

    public function store(MenuRequest $request)
    {
        try {
            $input = $request->all();
            if (!isset($input['parent_id'])) {
                $input['parent_id'] = NULL;
            }

            $data = $this->model->create($input);

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


    public function update(MenuRequest $request, $id)
    {
        try {
            $input = $request->all();

            $user = $this->model->find($id);
            if (!isset($input['parent_id'])) {
                $input['parent_id'] = NULL;
            }
                        
            $data = $user->update($input);

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
