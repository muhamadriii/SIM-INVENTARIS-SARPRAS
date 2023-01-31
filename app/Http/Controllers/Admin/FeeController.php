<?php

namespace App\Http\Controllers\Admin;

use View;
use App\Models\Fee;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeeRequest;
use App\DataTables\FeeDataTable;

class FeeController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Fee $fee){

        $this->middleware('can:fees.list')->only('index');
        $this->middleware('can:fees.create')->only('store');
        $this->middleware('can:fees.update')->only('update');
        $this->middleware('can:fees.delete')->only('destroy');

        $this->model    = $fee;
        $this->view     = "fee";
        $this->path     = "admin";
        $this->route    = "admin.fee";
        $this->title    = "Fee Management";

        View::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function index(FeeDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index');
    }

    public function store(FeeRequest $request)
    {
        try {
            $payload    = $request->all();
            $image      = $request->file();

            $data = $this->model->create($payload);
            // dd($data);
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


    public function update(FeeRequest $request, $id)
    {
        try {
            $payload = $request->all();
            $fee = $this->model->find($id);

            if($request->file('image'))
            $payload['image'] = FileHelper::saveImage($request->file('image'),500, public_path("fees"));

            $data = $fee->update($payload);

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
            $fee = $this->model->find($id);
            $data = $fee->delete();

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
