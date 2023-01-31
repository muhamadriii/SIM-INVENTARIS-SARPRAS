<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Merchant;
use App\Models\Member;
use App\Models\MemberAddress;
use App\DataTables\OrderWaitingForApprovalDataTable;
use App\DataTables\ListOrderDataTable;
use App\DataTables\OrderUnpaidDataTable;
use App\DataTables\OrderPaidDataTable;
use App\DataTables\OrderShippingDataTable;
use App\DataTables\OrderFinishDataTable;


use View;
use App\Helpers\FileHelper;

class TrackingOrderController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Order $order){

        $this->middleware('can:unpaid.list')->only('unpaid');
        $this->middleware('can:waiting-for-approval.list')->only('waitingForApproval');
        $this->middleware('can:paid.list')->only('paid');
        $this->middleware('can:shipping.list')->only('shipping');
        $this->middleware('can:finish.list')->only('finish');

        $this->model    = $order;
        $this->view     = "order-detail";
        $this->path     = "admin";
        $this->route    = "admin.order-detail";
        $this->title    = "Tracking Order";

        View::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function listOrder(ListOrderDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            ['Tracking Order', route('admin.order-detail.list-order')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.list-order');
    }

    public function unpaid(OrderUnpaidDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            ['Tracking Order', route('admin.order-detail.list-order')],
            ['Order Unpaid', route('admin.order-detail.unpaid')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.unpaid');
    }

    public function waitingForApproval(OrderWaitingForApprovalDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            ['Tracking Order', route('admin.order-detail.list-order')],
            ['Order Waiting For Approval', route('admin.order-detail.waiting-for-approval')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.waiting-for-approval');
    }

    public function paid(OrderPaidDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            ['Tracking Order', route('admin.order-detail.list-order')],
            ['Order Paid', route('admin.order-detail.paid')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.paid');
    }

    public function shipping(OrderShippingDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            ['Tracking Order', route('admin.order-detail.list-order')],
            ['Order Shipping', route('admin.order-detail.shipping')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.shipping');
    }

    public function finish(OrderFinishDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            ['Tracking Order', route('admin.order-detail.list-order')],
            ['Order Finish', route('admin.order-detail.finish')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.finish');
    }

}
