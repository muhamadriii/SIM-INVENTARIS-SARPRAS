<?php

namespace App\DataTables;

use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UnitsDataTable extends DataTable
{
    protected $model;
    protected $view;

    public function __construct(){
        $this->view     = "unit";
        $this->path     = "admin";
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', "pages.".$this->path.".".$this->view.'.action')
            ->editColumn('created_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->editColumn('updated_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'));
    }
    
    public function query(Unit $model)
    {
        return $model->newQuery();
    }


    public function html()
    {
        return $this->builder()
                    ->setTableId('units-table')
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
            Column::make('code'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }
}
