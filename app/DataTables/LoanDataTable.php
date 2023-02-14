<?php

namespace App\DataTables;

use App\Models\Loan;
use App\Models\Category;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use View;

class LoanDataTable extends DataTable
{
    protected $model;
    protected $view;

    public function __construct(){
        $this->view     = "loan";
        $this->path     = "admin";

        View::share('categories', Category::all());
        View::share('units', Unit::all());

    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            // ->addColumn('image', function($query) { return '<a src="'. asset('storage/images/item'). '/'. $query->image .'" class="img-fluid rounded image-modal" style="cursor:pointer">lihat foto</a>';})
            ->addColumn('action', "pages.".$this->path.".".$this->view.'.action')
            ->editColumn('created_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->editColumn('updated_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->rawColumns(['action']);
    }

    public function query(Loan $model)
    {
        return $model
                    // ->select('Loan_details.name as detail_name', 'units.name as unit_name', 'Loans.*')
                    // ->join('Loan_details', 'Loan_details.requet_id', '=', 'Loans.id')
                    // ->join('units', 'units.id', '=', 'Loans.unit_id')
                    // // ->with('unit')
                    // ->orderBy('created_at', 'desc')
                    ->newQuery();
    }


    public function html()
    {
        return $this->builder()
                    ->setTableId('loans-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
                    ->buttons(['export']);
    }


    protected function getColumns()
    {
        return [
            Column::make('name'),
            Column::make('phone_number'),
            Column::make('email'),
            Column::make('necessity'),
            Column::make('created_at'),
            Column::make('created_by'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

}
