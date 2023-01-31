<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\MerchantsDataTable;
use App\Http\Requests\MerchantRequest;
use Illuminate\Http\Request;
use App\Models\User;
use View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Helpers\FileHelper;
class MerchantController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(User $merchant){

        $this->middleware('can:merchant.list')->only('index');
        $this->middleware('can:merchant.create')->only('store');
        $this->middleware('can:merchant.update')->only('update');
        $this->middleware('can:merchant.delete')->only('destroy');

        $this->model    = $merchant;
        $this->view     = "merchants";
        $this->path     = "admin";
        $this->route    = "admin.merchants";
        $this->title    = "Merchant Management";

        View::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function index(MerchantsDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        $data = $this->model->get();

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index', compact('data'));
    }

    public function store(MerchantRequest $request)
    {
        try {
            $payload = $request->all();
            $image      = $request->file();

            $payload['type'] = 'merchant';

            $payload['password'] = Hash::make($payload['password']);

            if($request->file('image'))
            $payload['image'] = FileHelper::saveImage($request->file('image'),500, public_path("merchants"));

            // dd($payload);  
            $data = $this->model->create($payload);

            // $payload    = $request->all();
            // $image      = $request->file();

            // if($request->file('image'))
            //     $payload['image'] = FileHelper::saveImage($request->file('image'),500, public_path("merchants"));

            // $data = $this->model->create($payload);

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


    public function update(MerchantRequest $request, $id)
    {
        try {
            $payload = $request->all();
            $merchant = $this->model->find($id);

            if($request->file('image'))
            $payload['image'] = FileHelper::saveImage($request->file('image'),500, public_path("merchants"));

            if (!empty($payload['password'])) $payload['password'] = Hash::make($payload['password']);
            else unset($payload['password']);

            $data = $merchant->update($payload);

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

    public function destroy($id)
    {
        try {
            $merchant = $this->model->find($id);
            $data = $merchant->delete();

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
