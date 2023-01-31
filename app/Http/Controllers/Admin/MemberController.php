<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MemberDataTable;
use App\DataTables\MemberAddressDataTable;
use App\Models\Member;
use App\Models\MemberAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use App\Http\Requests\MemberRequest;
use App\Models\Level;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    protected $model;
    protected $view;

    public function __construct(Member $member)
    {
        // $this->middleware('can:member.list')->only('index');
        // $this->middleware('can:member.create')->only('store');
        // $this->middleware('can:member.update')->only('update');
        // $this->middleware('can:member.delete')->only('destroy');

        $this->model    = $member;
        $this->view     = "pages.admin.member";
        $this->route    = "admin.member";
        $this->title    = "Member Management";

        View::share('title', $this->title);
        View::share('view', $this->view);
        View::share('model', $this->model);
        View::share('route', $this->route);
    }

    public function index(MemberDataTable $dataTable)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')]
        ]);

        return $dataTable->render($this->view . '.index');
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
    public function store(MemberRequest $request)
    {
        DB::beginTransaction();
        try {
            Member::fixTree();

            $payload = $request->all();

            $payload['level'] = 0;
            $payload['parent'] = '';
            if (!empty($payload['code'])) {

                $parent = Member::whereCode($payload['code'])->first();
                if (empty($parent)) {
                    throw new Exception("Leader Code not found");
                }

                $payload['parent'] = $parent->id;
            } else {
                $payload['code'] = member_code();
                if($super_member =  Member::where('is_superadmin', 1)->first()) {
                    $payload['code'] = $super_member->code;
                }
            }

            $payload['password'] = Hash::make($payload['password']);

            $data = $this->model->create($payload);

            setAncesorsLevel($data->id);

            DB::commit();
            $response = [
                'success' => true,
                'message' => 'Success save data',
                'data' => $data
            ];

            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
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
    public function update(MemberRequest $request, $id)
    {

        try {
            $payload = $request->all();
            $user = $this->model->find($id);

            if (!empty($payload['password'])) $payload['password'] = Hash::make($payload['password']);
            else unset($payload['password']);

            $data = $user->update($payload);

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

    public function diagram(Request $request, $member_id)
    {
        $member = Member::find($member_id);
        $levels = Level::orderBy('level', 'ASC')->get();
        $members = Member::query()
            ->with('parent_data')
            ->whereDescendantOf($member);

        if (!empty($request->level)) {
            $members = $members->whereLevel($request->level);
        }

        $members = $members->get();

        $data['member'] = $member;
        $data['members'] = $members;
        $data['levels'] = $levels;

        return view($this->view . '.diagram', $data);
    }

    public function level($member_id)
    {
        View::share('breadcrumbs', [
            [$this->title, route($this->route.'.index')],
            ['Level Member', route($this->route.'.level', $member_id)]
        ]);

        $data['levels'] = Level::orderBy('level', 'asc')->get();
        $data['member'] = Member::find($member_id);

        return view($this->view . '.level', $data);
    }
}
