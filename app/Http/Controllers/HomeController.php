<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\LogMemberView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use View;

class HomeController extends Controller
{
    protected $categories;
    protected $listProducts;

    public function __construct()
    {
        $this->view     = "front-end.home.";
        View::share('view', $this->view);
        $this->categories = Category::all();
        View::share('categories', $this->categories);

        $this->listProducts = Category::has('products')->get();
        View::share('listProducts', $this->listProducts);

        // $this->merchants = Merchant::all();
        // View::share('merchants', $this->merchants);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    protected function user(){
        return Auth::guard('member')->user();
    }

    public function index()
    {
        return to_route('admin.login');
        dd('route nya "/admin" doang');
        $datas = Gallery::orderBy('created_at', 'desc')->limit(3)->get();
        $product = Product::with( 'category' ,'productImages')->get();
        $listProduct = Category::with('products')->get();
        $newProduct = Product::orderBy('created_at', 'DESC')->get();

        if (Auth::guard('member')->user()) {
            $recently_view = LogMemberView::whereMemberId(Auth::guard('member')->user()->id)->has('product')->orderBy('created_at','desc')->get();
        } else {
            $recently_view = LogMemberView::whereMemberId(null)->has('product')->orderBy('created_at','desc')->get();
        }

        // $avarage_rating = 0;
        // if (count($listProduct->products->ratings) > 0) {
        //     $avarage_rating     = $newProduct->ratings->sum('rating') / count($newProduct->ratings);
        // }

        $top_seller = OrderDetail::groupBy('user_id')
                    ->selectRaw('user_id, sum(qty) as count')
                    ->orderBy('count', 'desc')
                    ->has('user')
                    ->limit(3)
                    ->get();

        $top_new = OrderDetail::groupBy('product_id')
                    ->selectRaw('product_id, sum(qty) as count')
                    ->orderBy('count', 'desc')
                    ->has('product')
                    ->limit(7)
                    ->get();

        $users = User::whereType('merchant')->get();
        return view('pages.'.$this->view.'index', compact('datas', 'product', 'recently_view', 'top_seller', 'users', 'top_new', 'listProduct', 'newProduct'));
    }

}
