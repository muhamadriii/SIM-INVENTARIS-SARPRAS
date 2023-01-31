<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\PaymentDataTable;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

use View;
use App\Helpers\FileHelper;

class PaymentController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Payment $payment){
        $this->model    = $payment;
        $this->view     = "payment";
        $this->path     = "admin";
        $this->route    = "admin.payment";
        $this->title    = "Payment Management";

        View::share('path', $this->path);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('title', $this->title);
        // View::share('products', Product::all());
        // View::share('merchants', Merchant::all());
        // View::share('members', Member::all());
    }

    public function index(PaymentDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        return $dataTable->render("pages.".$this->path.".".$this->view.'.index');
    }

    public function show($id)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')],
            ['Payment Detail', route($this->route.'.show', $id)]
        ]);

        // $order = Order::with('order_details')->find($id);
        $months = config('variables.months');
        $status = config('variables.payment_status');

        $payment = Payment::findOrFail($id);
        $paymentDetails = Payment::where('member_id', $id)->get();

        return view('pages.admin.payment.detail', compact('paymentDetails', 'payment', 'status', 'months', 'id'));
    }

    public function pdf($id)
    {
        $t = time();
        $months = config('variables.months');
        $status = config('variables.payment_status');

        $payment = Payment::findOrFail($id);
        $paymentDetails = Payment::where('member_id', $id)->get();

        $pdf = Pdf::loadview('pages.admin.payment.pdf', compact('paymentDetails', 'payment', 'status', 'id', 'months'));
        return $pdf->download( 'invoice'.' '. $payment->member->name.' '.date("Y-m-d",$t).'.pdf');
    }

    public function destroy($id)
    {
        try {
            $order = $this->model->find($id);
            $data = $order->delete();

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

    public function updateStatus($id)
    {
        try {
            $payment = $this->model->find($id);
            $input = ['status' => $payment->status + 1];
            $data = $payment->update($input);

            $response = [
                'success' => true,
                'message' => 'Success update status',
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

    public function paymentGenerate(Request $request)
    {
        /* php artisan config:clear */
        \Artisan::call('payment:generate');
        return redirect()->back();
    }
}
