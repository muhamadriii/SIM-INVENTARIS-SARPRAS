<?php

namespace App\Http\Controllers\Admin;

use View;
use App\Models\Category;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\DataTables\CategoriesDataTable;

class CategoryController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Category $category){

        $this->middleware('can:categories.list')->only('index');
        $this->middleware('can:categories.create')->only('store');
        $this->middleware('can:categories.update')->only('update');
        $this->middleware('can:categories.delete')->only('destroy');

        $this->model    = $category;
        $this->view     = "categories";
        $this->path     = "admin";
        $this->route    = "admin.categories";
        $this->title    = "Category Management";

        View::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function index(CategoriesDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index');
    }

    public function store(CategoryRequest $request)
    {
        try {
            $payload    = $request->all();
            $image      = $request->file();

            if($request->file('image'))
                $payload['image'] = FileHelper::saveImage($request->file('image'),500, public_path("categories"));

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


    public function update(CategoryRequest $request, $id)
    {
        try {
            $payload = $request->all();
            $category = $this->model->find($id);

            if($request->file('image'))
            $payload['image'] = FileHelper::saveImage($request->file('image'),500, public_path("categories"));

            $data = $category->update($payload);

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
            $category = $this->model->find($id);
            $data = $category->delete();

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
