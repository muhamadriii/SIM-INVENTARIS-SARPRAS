<?php

namespace App\DataTables;

use App\Models\Order;
use App\Models\Category;
use App\Models\Payment;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use View;

class PaymentDataTable extends DataTable
{
    protected $model;
    protected $view;

    public function __construct(){
        $this->view     = "payment";
        $this->path     = "admin";

        View::share('categories', Category::all());
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', "pages.".$this->path.".".$this->view.'.action')
            ->addColumn('status', function ($query) {
                if ($query->status == 0) {
                    $status = 'Unpaid';
                }elseif ($query->status == 1){
                    $status = 'Waiting for approval';
                }elseif ($query->status == 2){
                    $status = 'Paid';
                }
                return $status;
            })

            ->addColumn('month', function ($query) {
                if ($query->month == 1) {
                    $month = 'January';
                }elseif ($query->month == 2){
                    $month = 'February';
                }elseif ($query->month == 3){
                    $month = 'March';
                }elseif ($query->month == 4){
                    $month = 'April';
                }elseif ($query->month == 5){
                    $month = 'May';
                }elseif ($query->month == 6){
                    $month = 'June';
                }elseif ($query->month == 7){
                    $month = 'July';
                }elseif ($query->month == 8){
                    $month = 'August';
                }elseif ($query->month == 9){
                    $month = 'September';
                }elseif ($query->month == 10){
                    $month = 'October';
                }elseif ($query->month == 11){
                    $month = 'November';
                }elseif ($query->month == 12){
                    $month = 'December';
                }
                return $month;
            })

            ->addColumn('amount', function($query) { return  'Rp. '. number_format($query->amount); })
            ->editColumn('created_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->editColumn('updated_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->rawColumns(['amount', 'action']);
    }

    public function query(Payment $model)
    {
        return $model->select('members.name as member_name', 'payments.*')
        ->join('members', 'members.id', '=', 'payments.member_id')
        ->orderBy('created_at', 'desc')
        ->newQuery();
    }


    public function html()
    {
        return $this->builder()
                    ->setTableId('payments-table')
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
            Column::make('amount'),
            Column::make('month'),
            Column::make('year'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }
}
