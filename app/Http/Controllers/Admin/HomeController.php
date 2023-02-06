<?php

namespace App\Http\Controllers\Admin;

use App\Models\Level;
use App\Models\Order;
use App\Models\Member;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\DataTables\ListOrderDataTable;
use Illuminate\Support\Facades\Storage;
// use function GuzzleHttp\Promise\all;
// use App\Helpers\FileHelper;
// use Kalnoy\Nestedset\NodeTrait;



class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(ListOrderDataTable $dataTable)
    {
        return to_route('admin.users.index');
        $members = Member::get();
        $datas = [];
        foreach($members as $member) {
            for($level = 1; $level <= 100; $level++)
            {
                $level_data = Level::whereLevel($level)->first();
                $count_member_level = $member->withDepth()->having('depth', '=', $level)->count();
                if($count_member_level == 0)
                {
                    break;
                }
                else
                {
                    $previous_level         = $level - 1;
                    $previous_total_member  = 0;
                    if($level > 1) {
                        $previous_total_member                  = $datas[$previous_level]['total_member_by_level'];
                        $datas[$level]['total_member_by_level'] = $count_member_level * 2 + $previous_total_member;
                    }
                    else
                    {
                        $datas[$level]['total_member_by_level'] = 1;
                    }
                    $datas[$level]['count_member']                  = $count_member_level;
                    $datas[$level]['total_member_by_pack']          = $count_member_level + $previous_total_member;
                    $datas[$level]['monthly_spend']                 = 1000000;
                    $datas[$level]['omzet']                         = 1000000 * $datas[$level]['total_member_by_level'];
                    $datas[$level]['commission']                    = @$level_data->commission_level_percent;
                    $datas[$level]['summary_commission']            = 1000000 * @$level_data->commission_level_percent / 100;
                    $datas[$level]['dividen_commission']            = $datas[$level]['total_member_by_level'] * 1000000 * @$level_data->commission_level_percent / 100;
                    $datas[$level]['assum_summary_commission']      = 20 * $datas[$level]['omzet'] / 100;
                    $datas[$level]['assum_summary_commission_clean']= $datas[$level]['assum_summary_commission'] - $datas[$level]['dividen_commission'];
                    $datas[$level]['adminstration']                 = 1000000 * 50 / 100;
                    $datas[$level]['sum_adminstration']             = $datas[$level]['adminstration'] * $datas[$level]['total_member_by_pack'];
                }
    
            }
        }
       
        $populer_products = OrderDetail::has('product')
        ->groupBy('product_id')
        ->selectRaw('product_id, sum(qty) as count')
        ->orderBy('count', 'desc')
        ->limit(8)
        ->get();
        
        
        $months = ['January', 'February', 'March', 'April', 'May', 'Juny', 'July', 'Agust', 'September', 'October', 'November', 'December'];
        
        
        foreach ($months as $key => $month) {
            $countOrder[] = Order::query()
            ->where(DB::raw("MONTHNAME(date)"), $month)
            ->whereYear('date', now()->year)
            ->count();
        }
        
        
        $orderByMonth = json_encode($countOrder);
        
        return $dataTable->render('pages.admin.dashboard', compact('populer_products', 'orderByMonth', 'datas'));
        
        
       
    }

   
   

}
