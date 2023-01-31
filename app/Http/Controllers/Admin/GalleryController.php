<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\GalleryDataTable;
use App\Http\Requests\GalleryRequest;
use Illuminate\Http\Request;
use App\Models\Gallery;
use View;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\Storage;


class GalleryController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Gallery $gallery){

        $this->middleware('can:gallery.list')->only('index');
        $this->middleware('can:gallery.create')->only('store');
        $this->middleware('can:gallery.update')->only('update');
        $this->middleware('can:gallery.delete')->only('destroy');

        $this->model    = $gallery;
        $this->view     = "gallery";
        $this->path     = "admin";
        $this->route    = "admin.gallery";
        $this->title    = "Gallery Management";

        View::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function index(GalleryDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index');
    }

    public function store(GalleryRequest $request)
    {
        try {

            $request->validate([
                'name'          => 'required',
                'image'         => 'required',
                'url'       => 'required',

            ], [
                'name.required' => 'Nama harus diisi',
                'image.required' => 'Image harus diisi',
                'url.required' => 'Url harus diisi',
            ]);

            $payload    = $request->all();
            $image      = $request->file();

            if($request->file('image'))
                $payload['image'] = FileHelper::saveImage($request->file('image'),500, public_path("galleries"));

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


    public function update(GalleryRequest $request, $id)
    {
        try {
            $payload = $request->all();
            $gallery = $this->model->find($id);

            if($request->file('image'))
            $payload['image'] = FileHelper::saveImage($request->file('image'),500, public_path("galleries"));

            $data = $gallery->update($payload);

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
            $gallery = $this->model->find($id);
            $data = $gallery->delete();

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
