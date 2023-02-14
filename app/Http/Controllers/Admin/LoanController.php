<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LoanDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoanRequest;
use App\Models\Loan;
use App\Models\LoanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use View;
class LoanController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Loan $Loan){
        $this->middleware('can:loan.list')->only('index');
        $this->middleware('can:loan.create')->only('store');
        $this->middleware('can:loan.update')->only('update');
        $this->middleware('can:loan.delete')->only('destroy');

        $this->model    = $Loan;
        $this->view     = "loan";
        $this->path     = "admin";
        $this->route    = "admin.loans";
        $this->title    = "Loans Management";

        view::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
    }

    public function index(LoanDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index');
    }

    public function store(LoanRequest $request)
    {
        // dd($request->all());
        try {
            $payload = $request->all();
            $payload['created_by'] = Auth::user()->name;
            $payload['updated_by'] = Auth::user()->name;
            $payload['loan_date'] = now();
            $data = $this->model->create($payload);

            $payloadDetail['loan_id'] = $data->id;
            $payloadDetail['status'] = 0;
            $payloadDetail['return_date'] = $request->return_date;
            $payloadDetail['created_by'] = $payload['created_by'];
            $payloadDetail['updated_by'] = $payload['updated_by'];
            foreach ($payload['sku_item'] as $key => $value) {
                $payloadDetail['sku_item'] = $value;
                LoanDetail::create($payloadDetail);
            }

            $response = [
                'success' => true,
                'message' => 'Success save data',
                'data' => $data
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Server Error',
                'data' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }

    }


    public function show($id)
    {
        try {
            $data = $this->model->find($id);

            $response = [
                'success' => true,
                'message' => 'Success retrieve data',
                'data' => $data
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Server Error',
                'data' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }


    public function update(LoanLoan $Loan, $id)
    {
        try {
            $payload = $Loan->all();
            $Loan = $this->model->find($id);

            $data = $Loan->update($payload);

            $response = [
                'success' => true,
                'message' => 'Success save data',
                'data' => $data
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];
            return response()->json($response, 500);
        }
    }


    public function destroy($id)
    {
        try {
            $Loan = $this->model->find($id);
            $data = $Loan->delete();

            $response = [
                'success' => true,
                'message' => 'Success delete data',
                'data' => $data
            ];

            return response()->json($response);

        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];
            return response()->json($response, 500);
        }
    }
}
