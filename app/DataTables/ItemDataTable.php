<?php

namespace App\DataTables;

use App\Models\Item;
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

class ItemDataTable extends DataTable
{
    protected $model;
    protected $view;

    public function __construct(){
        $this->view     = "item";
        $this->path     = "admin";
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('image', function($query) { return '<p>rgrsbg</p>';})
            // ->addColumn('qr_code', function($query) { return '
            //     <div class="" style="width:50px; max-height:50px; cursor:pointer;">
            //         <img src="'. asset('storage/images/item'). '/'. $query->sku .'.svg'.'" class="img-fluid rounded image-modal" /> 
            //     </div>
            //     ';})
            ->addColumn('action', "pages.".$this->path.".".$this->view.'.action')
            ->editColumn('created_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->editColumn('updated_at', Carbon::parse($this->created_at)->format('Y-m-d H:i'))
            ->rawColumns(['action']);
    }

    public function query(Item $model)
    {
        return $model->select('parent_items.name as nama_barang',  'items.*')
                    ->join('parent_items', 'parent_items.id', '=', 'items.parent_id')
                    // ->join('categories', 'categories.id', '=', 'parent_items.category_id')
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
            Column::make('nama_barang'),
            Column::make('color'),
            Column::make('sku'),
            Column::make('image'),
            // Column::make('qr_code'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

}
