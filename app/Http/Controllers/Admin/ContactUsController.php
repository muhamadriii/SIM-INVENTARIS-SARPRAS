<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\ContactUsDataTable;
use App\Http\Requests\ContactUsRequest;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use View;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\Storage;


class ContactUsController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(ContactUs $contact){
        
        $this->middleware('can:contact-us.list')->only('index');
        $this->middleware('can:contact-us.create')->only('store');
        $this->middleware('can:contact-us.update')->only('update');
        $this->middleware('can:contact-us.delete')->only('destroy');

        $this->model    = $contact;
        $this->view     = "contact-us";
        $this->path     = "admin";
        $this->route    = "admin.contact-us";
        $this->title    = "Contact Us Management";

        View::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function index(ContactUsDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index');
    }

    public function store(ContactUsRequest $request)
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


    public function update(ContactUsRequest $request, $id)
    {
        try {
            $payload = $request->all();
            $contact = $this->model->find($id);

            $data = $contact->update($payload);

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
            $contact = $this->model->find($id);
            $data = $contact->delete();

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
