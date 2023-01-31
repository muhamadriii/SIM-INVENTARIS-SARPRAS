<?php

namespace App\DataTables;

use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use View;

class MerchantsDataTable extends DataTable
{
    protected $model;
    protected $view;

    public function __construct(){
        $this->view     = "merchants";
        $this->path     = "admin";
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('image', function($query) { return '<img src="'. asset('merchants'). '/' . $query->image .'" class="img-fluid rounded image-modal" />'; })
                
            ->addColumn('action', "pages.".$this->path.".".$this->view.'.action')
            ->editColumn('created_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->editColumn('updated_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->rawColumns(['image', 'action']);
        
    }
    
    public function query(User $model)
    {
        return $model->whereType('merchant')->newQuery();
    }


    public function html()
    {
        return $this->builder()
                    ->setTableId('merchants-table')
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
            Column::make('username'),
            Column::make('email'),
            Column::make('image'),
            Column::make('type'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

}
