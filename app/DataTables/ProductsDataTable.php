<?php

namespace App\DataTables;

use App\Models\Product;
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

class ProductsDataTable extends DataTable
{
    protected $model;
    protected $view;

    public function __construct(){
        $this->view     = "products";
        $this->path     = "admin";

        View::share('categories', Category::all());
        View::share('users', User::whereType('merchant')->get());
        View::share('units', Unit::all());

    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('image', function($query) { return '<a class="img-fluid rounded image-modal" data-id="'.$query->id.'" >Show Image</a>'; })
            ->addColumn('action', "pages.".$this->path.".".$this->view.'.action')
            ->editColumn('created_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->editColumn('updated_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->rawColumns(['image', 'action']);

    }

    public function query(Product $model)
    {
        return $model->select('categories.name as category_name', 'products.*')
                    ->join('categories', 'categories.id', '=', 'products.category_id')
                    ->with('user','productImages', 'unit')
                    ->orderBy('created_at', 'desc')
                    ->newQuery();
    }


    public function html()
    {
        return $this->builder()
                    ->setTableId('products-table')
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
            Column::make('user.name'),
            Column::make('unit.name'),
            Column::make('name'),
            Column::make('image'),
            Column::make('stock'),
            Column::make('short_description'),
            Column::make('sku'),
            Column::make('price'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

}
