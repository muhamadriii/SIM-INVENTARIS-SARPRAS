<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MemberAddressDataTable;
use App\Models\MemberAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use App\Http\Requests\MemberAddressRequest;
use App\Models\Level;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberAddressController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(MemberAddress $member)
    {
        $this->model    = $member;
        $this->view     = "pages.admin.member-address";
        $this->route    = "admin.member";
        $this->title    = "Member Address Management";

        View::share('title', $this->title);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('route', $this->route);
    }

    public function index(MemberAddressDataTable $dataTable, $member_id)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.member-address', $member_id)]
        ]);

        return $dataTable->with('member_id', $member_id)->render($this->view . '.index', compact('member_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Member::all();
        return  to_route('', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberAddressRequest $request)
    {
        try {
            $input = $request->all();
            
            $member_address = [
                'member_id' => $input['member_id'],
                'member_address' => $input['member_address']
            ];
            
            $data = MemberAddress::create($member_address);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->model->find($id);
            // dd($data);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            $payload = $request->all();

            $member_address = $this->model->find($id);

            $data = $member_address->update($payload);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $member = $this->model->find($id);
        // dd($member
            $data = $member->delete();

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
