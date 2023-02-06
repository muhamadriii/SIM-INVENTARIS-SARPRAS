<?php

namespace App\DataTables;

use App\Models\ParentItem;
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

class ParentItemDataTable extends DataTable
{
    protected $model;
    protected $view;

    public function __construct(){
        $this->view     = "parent-item";
        $this->path     = "admin";

        View::share('categories', Category::all());
        View::share('units', Unit::all());

    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('image', function($query) { return '<a src="'. asset('storage/images/item'). '/'. $query->image .'" class="img-fluid rounded image-modal" style="cursor:pointer">lihat foto</a>';})
            ->addColumn('action', "pages.".$this->path.".".$this->view.'.action')
            ->editColumn('created_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->editColumn('updated_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->rawColumns(['image', 'action']);

    }

    public function query(ParentItem $model)
    {
        return $model->select('categories.name as category_name', 'units.name as unit_name', 'parent_items.*')
                    ->join('categories', 'categories.id', '=', 'parent_items.category_id')
                    ->join('units', 'units.id', '=', 'parent_items.unit_id')
                    // ->with('unit')
                    ->orderBy('created_at', 'desc')
                    ->newQuery();
    }


    public function html()
    {
        return $this->builder()
                    ->setTableId('parent_items-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
                    ->buttons(['export']);
    }


    protected function getColumns()
    {
        return [
            Column::make('category_name'),
            Column::make('unit_name'),
            Column::make('name'),
            Column::make('suplier'),
            Column::make('description'),
            Column::make('stock'),
            Column::make('price'),
            Column::make('image'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

}
