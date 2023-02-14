<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RequestDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestRequest;
use App\Models\Request as Model;
use App\Models\RequestDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use View;
class RequestController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Model $Request){
        $this->middleware('can:request.list')->only('index');
        $this->middleware('can:request.create')->only('store');
        $this->middleware('can:request.update')->only('update');
        $this->middleware('can:request.delete')->only('destroy');

        $this->model    = $Request;
        $this->view     = "Request";
        $this->path     = "admin";
        $this->route    = "admin.requests";
        $this->title    = "Requests Management";

        view::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function index(RequestDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index');
    }

    public function store(RequestRequest $request)
    {
        // dd($request->all());

        try {
            $payload = $request->all();
            $payload['created_by'] = Auth::user()->name;
            $payload['updated_by'] = Auth::user()->name;
            $payload['status'] = 0;
            $data = $this->model->create($payload);

            $payloadDetail['request_id'] = $data->id;
            $payloadDetail['created_by'] = $payload['created_by'];
            $payloadDetail['updated_by'] = $payload['updated_by'];
            foreach ($payload['sku_item'] as $key => $value) {
                $payloadDetail['sku_item'] = $value;
                RequestDetail::create($payloadDetail);
            }

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


    public function update(RequestRequest $request, $id)
    {
        try {
            $payload = $request->all();
            $Request = $this->model->find($id);

            $data = $Request->update($payload);

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
            $Request = $this->model->find($id);
            $data = $Request->delete();

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
