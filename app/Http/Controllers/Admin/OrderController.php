<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\OrdersDataTable;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\Member;
use App\Models\MemberAddress;


use View;
use App\Helpers\FileHelper;

class OrderController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Order $order){

        $this->middleware('can:order.list')->only('index');
        $this->middleware('can:order.create')->only('store');
        $this->middleware('can:order.update')->only('update');
        $this->middleware('can:order.delete')->only('destroy');
        $this->middleware('can:order.updateStatus')->only('updateStatus');

        $this->model    = $order;
        $this->view     = "orders";
        $this->path     = "admin";
        $this->route    = "admin.orders";
        $this->title    = "Order Management";

        View::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
        View::share('products', Product::all());
        View::share('merchants', Merchant::all());
        View::share('members', Member::all());
    }

    public function index(OrdersDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        $orders = Order::get();

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index', compact('orders'));
    }

    public function create(Request $request)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')],
            ["Create Order", route($this->route.'.create')]
        ]);

        $products = Product::all();
        $product_list = [];
        foreach($products as $product) {
            $product_list[$product->id] = $product->price;
        }

        $product_list = json_encode($product_list);

        return view('pages.' . $this->path . "." . $this->view . '.create', compact('product_list'));
    }


    public function store(OrderRequest $request)
    {
        try {
            $input = $request->all();
            // dd($input);
            // dd($input);
            $order_data = [
                'member_id' => $input['member_id'],
                'order_code' => order_code(),
                'date' => $input['date'],
                'status' => 0,
                'member_address_id' => $input['member_address_id'],
                'description' => $input['description'],
            ];
            $order = Order::create($order_data);

            $total = 0;
            foreach ($input['product_id'] as $key => $value) {
                $product = Product::find($value);
                $order_detail_data = [
                    'order_id' => $order->id,
                    'product_id' => $value,
                    'qty' => $input['qty'][$key],
                    'price' => $product->price,
                    'user_id' => $product->user_id,
                    'product_name' => $product->name,
                    'product_description' => $product->description,
                    'merchant_name' => $product->user->name,
                ];
                // dd($order_detail_data);
                $order_detail_data = OrderDetail::create($order_detail_data);

                $total += $product->price * $input['qty'][$key];
            }

            Order::find($order->id)->update(['total'=>$total]);

            $response = [
                'success' => true,
                'message' => 'Success save data',
                'data' => $order
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


    // public function show($id)
    // {
    //     try {
    //         $data = $this->model->with('category')->find($id);
    //         $response = [
    //             'success' => true,
    //             'message' => 'Success retrieve data',
    //             'data' => $data
    //         ];

    //         return response()->json($response);
    //     } catch (\Exception $e) {
    //         $response = [
    //             'success' => false,
    //             'message' => 'Server Error',
    //             'data' => $e->getMessage()
    //         ];
    //         return response()->json($response, 500);
    //     }
    // }

    public function show($id)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')],
            ['Order Detail', route($this->route.'.show', $id)]
        ]);

        $order = Order::with('order_details')->find($id);

        return view('pages.admin.orders.detail', compact('order'));
    }

    public function edit($id)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')],
            ['Edit Order', route($this->route.'.edit', $id)]
        ]);

        $order = Order::with('order_details', 'member_address')->find($id);
        // dd($order->member_address);
        return view('pages.admin.orders.edit', compact('order'));
    }


    public function update(OrderRequest $request, $id)
    {
        try {
            $input = $request->all();
            $order = $this->model->find($id);

            $total = 0;
            $order_detail_data = [];
            $delete = OrderDetail::whereOrderId($id)->delete();
            foreach ($input['product_id'] as $key => $value) {
                $product = Product::find($value);
                $order_detail_data[] = [
                    'order_id' => $id,
                    'product_id' => $value,
                    'qty' => $input['qty'][$key],
                    'price' => $product->price,
                    'user_id' => $product->user_id,
                    'product_name' => $product->name,
                    'product_description' => $product->description,
                    'merchant_name' => $product->user->name,
                ];

                $total += $product->price * $input['qty'][$key];
            }
            $order_detail_data = OrderDetail::insert($order_detail_data);

            $input['total'] = $total;
            $data = $order->update($input);

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
            $order = $this->model->find($id);
            $data = $order->delete();
            OrderDetail::whereOrderId($id)->delete();

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

    public function getAddress(Request $request)
    {
        try {
            $data = MemberAddress::whereMemberId($request->member_id)->get();

            return response()->json($data);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Server Error',
                'data' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function updateStatus($id)
    {
        try {
            $order = $this->model->find($id);
            $input = ['status' => $order->status + 1];
            $data = $order->update($input);

            $response = [
                'success' => true,
                'message' => 'Success update status',
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

    public function showResi($id)
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


    public function addResi(Request $request, $id)
    {
        try {
            $input = $request->all();
            $order = $this->model->find($id);
            $input['status'] = 3;
            $data = $order->update($input);

            $response = [
                'success' => true,
                'message' => 'Success update status',
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
