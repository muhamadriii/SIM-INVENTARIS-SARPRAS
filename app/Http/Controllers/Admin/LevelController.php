<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LevelDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\LevelRequest;
use Spatie\Permission\Models\Role;
use App\Models\Level;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use View;

class LevelController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Level $user)
    {
        $this->middleware('can:level.list')->only('index');
        $this->middleware('can:level.create')->only('store');
        $this->middleware('can:level.update')->only('update');
        $this->middleware('can:level.delete')->only('destroy');

        $this->model    = $user;
        $this->view     = "pages.admin.level";
        $this->route    = "admin.levels";
        $this->title    = "Level Management";

        View::share('route', $this->route);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function index(LevelDataTable $dataTable)
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

    public function store(LevelRequest $request)
    {
        try {
            $input = $request->all();

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


    public function update(LevelRequest $request, $id)
    {
        try {
            $payload = $request->all();
            $user = $this->model->find($id);

            $data = $user->update($payload);

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
