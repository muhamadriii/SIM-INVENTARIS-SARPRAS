<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\ProductsDataTable;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use View;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Product $product){

        $this->middleware('can:product.list')->only('index');
        $this->middleware('can:product.create')->only('store');
        $this->middleware('can:product.update')->only('update');
        $this->middleware('can:product.delete')->only('destroy');

        $this->model    = $product;
        $this->view     = "products";
        $this->path     = "admin";
        $this->route    = "admin.products";
        $this->title    = "Product Management";

        View::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function index(ProductsDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        $product_images = ProductImage::where('product_id')->get();

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index');
    }

    public function store(ProductRequest $request)
    {
        try {
            $input = $request->all();
            $product = $this->model->create($input);

            foreach ($input['image'] as $key => $value) {
                $product_images_data = [
                    'product_id' => $product->id,
                ];
                $product_images_data['image'] = FileHelper::saveImage($value ,500, public_path("products"));

                $product_images = ProductImage::create($product_images_data);
            }

            $response = [
                'success' => true,
                'message' => 'Success save data',
                'data' => $product
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
            $data = $this->model->with('category','user','productImages')->find($id);
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


    public function update(ProductRequest $request, $id)
    {
        try {
            $input = $request->all();
            $product = $this->model->find($id);

            if(isset($input['image'])){
                $product_images_data = [];
                $delete = ProductImage::whereProductId($id)->delete();
                foreach ($input['image'] as $key => $value) {
                    $product_images_data = [
                        'product_id' => $product->id,
                        'image' =>  FileHelper::saveImage($value ,500, public_path("products"))
                    ];

                    ProductImage::create($product_images_data);
                    // $product_images_data['image'] = FileHelper::saveImage($value ,500, public_path("products"));
                }

                // $product_images = ProductImage::insert($product_images_data);
            }

            $data = $product->update($input);

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
            ProductImage::whereProductId($id)->delete();
            $product = $this->model->find($id);
            $data = $product->delete();

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

    public function productImages($id)
    {
        try {
            $data = ProductImage::where('product_id', $id)->get();
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

}
