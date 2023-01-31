<?php

namespace App\Http\Controllers\Admin;

use View;
use App\Models\Invoice;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\DataTables\InvoiceDataTable;

class InvoiceController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Invoice $invoice){

        $this->middleware('can:invoices.list')->only('index');
        $this->middleware('can:invoices.create')->only('store');
        $this->middleware('can:invoices.update')->only('update');
        $this->middleware('can:invoices.delete')->only('destroy');

        $this->model    = $invoice;
        $this->view     = "Invoice";
        $this->path     = "admin";
        $this->route    = "admin.invoice";
        $this->title    = "Invoice Management";

        View::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function index(InvoiceDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index');
    }

    public function store(InvoiceRequest $request)
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


    public function update(InvoiceRequest $request, $id)
    {
        try {
            $payload = $request->all();
            $invoice = $this->model->find($id);

            if($request->file('image'))
            $payload['image'] = FileHelper::saveImage($request->file('image'),500, public_path("Invoices"));

            $data = $invoice->update($payload);

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
            $invoice = $this->model->find($id);
            $data = $invoice->delete();

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
