<?php

namespace App\DataTables;

use App\Models\Order;
use App\Models\Category;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use View;

class OrderUnpaidDataTable extends DataTable
{
    protected $model;
    protected $view;

    public function __construct(){
        $this->view     = "pages.admin.order-detail";
        $this->path     = "admin";
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', $this->view.'.action')
            ->addColumn('status', function ($query) {
                if ($query->status == 0) {
                    $status = 'Unpaid';
                }elseif ($query->status == 1){
                    $status = 'Waiting for approval';
                }elseif ($query->status == 2){
                    $status = 'Paid';
                }elseif ($query->status == 3){
                    $status = 'Shipping';
                }else{
                    $status = 'Finish';
                }

                return $status;
            })
            ->addColumn('total', function($query) { return  'Rp. '. number_format($query->total); })
            ->editColumn('created_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->editColumn('updated_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->rawColumns(['total', 'action']);
    }
    
    public function query(Order $model)
    {
        return $model->select('members.name as member_name', 'orders.*')
        ->join('members', 'members.id', '=', 'orders.member_id')
        ->where('orders.status', '0')
        ->orderBy('created_at', 'desc')
        ->newQuery();
    }


    public function html()
    {
        return $this->builder()
                    ->setTableId('orders-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy('0')
                    ->buttons(['export']);
    }

    
    protected function getColumns()
    {
        return [
            Column::make('member_name'),
            Column::make('order_code'),
            Column::make('date'),
            Column::make('total'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }
}
