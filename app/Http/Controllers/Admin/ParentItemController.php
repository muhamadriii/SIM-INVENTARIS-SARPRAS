<?php

namespace App\Http\Controllers\Admin;

use App\Models\ParentItem;
use App\Models\Item;
use App\Models\Unit;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\DataTables\ParentItemDataTable;
use App\Http\Requests\ParentItemRequest;
use App\Http\Requests\ItemRequest;
use Illuminate\Http\Request;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use View;


class ParentItemController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(ParentItem $ParentItem){

        $this->middleware('can:item.list')->only('index');
        $this->middleware('can:item.create')->only('store');
        $this->middleware('can:item.update')->only('update');
        $this->middleware('can:item.delete')->only('destroy');
        $this->middleware('can:item.generate')->only('GenerateQrcode');

        $this->model    = $ParentItem;
        $this->view     = "Item";
        $this->path     = "admin";
        $this->route    = "admin.items";
        $this->title    = "Item Management";

        View::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function index(ParentItemDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index');
    }

    public function store(ParentItemRequest $request)
    {
        try {
            $input = $request->all();
            $input['image'] = FileHelper::saveImage($input['image'] ,500, public_path("storage\images\item"));
            $ParentItem = $this->model->create($input);

            $response = [
                'success' => true,
                'message' => 'Success save data',
                'data' => $ParentItem
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
            $data = $this->model->with('category','unit')->find($id);
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

    public function update(ParentItemRequest $request, $id)
    {
        try {
            $input = $request->all();
            $input['image'] = FileHelper::saveImage($input['image'] ,500, public_path("storage\images\item"));
            $ParentItem = $this->model->find($id);
            $ParentItem->update($input);

            $response = [
                'success' => true,
                'message' => 'Success save data',
                'data' => $ParentItem
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
            $ParentItem = $this->model->find($id);
            $data = $ParentItem->delete();

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
    
    public function GenerateQrcode(ItemRequest $request, $id) {
        try {
            $parent = $this->model->with('unit','category')->find($id);
            $category = $parent->category->code;
            $unit = $parent->unit->code;
            $color = substr($request->color, 0, 3);
            $code = Str::random(6);
            $auth = Auth::user()->name;
            
            //status 0 = sku baru, 1 = sku lama(cetak ulang)
            if($request->sku == 0){
                $sku = strtoupper($category.'-'.$unit.'-'.$color.'-'.$code);
            }else {
                $sku = strtoupper($request->sku);
            }
            $qrcode = QrCode::style('square')->size(150)->generate($sku, '../public/storage/images/item/'.$sku.'.svg');
            $urlQrcode = url('storage/images/item').'/'.$sku.'.svg';
            $data = Item::create([
                'parent_id' => $id ,
                'sku' => $sku ,
                'color' => $color ,
                'status' => $request->status ,
                'count_print' => 0 ,
                'created_by' => $auth ,
                'updated_by' => $auth ,
            ]);

            $response = [
                'success' => true,
                'message' => 'Success Generate SKU & QR-Code',
                'data' => $data,
                'url' => $urlQrcode,
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
