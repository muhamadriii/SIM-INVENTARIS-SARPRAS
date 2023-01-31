<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UnitsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use Illuminate\Http\Request;
use View;
class UnitController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Unit $unit){
        $this->middleware('can:unit.list')->only('index');
        $this->middleware('can:unit.create')->only('store');
        $this->middleware('can:unit.update')->only('update');
        $this->middleware('can:unit.delete')->only('destroy');

        $this->model    = $unit;
        $this->view     = "unit";
        $this->path     = "admin";
        $this->route    = "admin.unit";
        $this->title    = "Units Management";

        view::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function index(UnitsDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index');
    }

    public function store(UnitRequest $request)
    {
        try {
            $payload = $request->all();

            $data = $this->model->create($payload);

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


    public function update(UnitRequest $request, $id)
    {
        try {
            $payload = $request->all();
            $unit = $this->model->find($id);

            $data = $unit->update($payload);

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
            $unit = $this->model->find($id);
            $data = $unit->delete();

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
