<?php

namespace App\Http\Controllers;

use App\Models\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\Company;
use App\Models\Plant;
use App\Models\CostCenter;
use App\Models\Approver;
use App\Models\Status;
use App\Models\User;
use App\Models\Room;
use App\Models\ServiceType;
use DateTime;

class UserRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {
        $this->middleware('permission:request-list|request-create|request-edit|request-delete', ['only' => ['index','show']]);
        $this->middleware('permission:request-create', ['only' => ['create','store']]);
        $this->middleware('permission:request-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:request-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = UserRequest::orderBy('id','DESC')->paginate()->where('user_id', Auth::id());
        return view('requests.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Return an array of companies
     */
    public function listCompanies()
    {
        $companies = Company::all();
        return response($companies, 200);
    }

    /**
     * Return an array of plants
     */
    public function listPlants(String $id)
    {
        $plants = Plant::where('company_id', $id)->get();
        return response($plants, 200);
    }

    /**
     * Return an array of cost centers
     */
    public function listCostCenter(String $id)
    {
        $constCenters = CostCenter::where('plant_id', $id)->get();
        return response($constCenters, 200);
    }

    /**
     * Return an array of approvers
     */
    public function listApprovers(String $id)
    {
        $approvers = Approver::where('company_id', $id)->get();
        $users = [];
        foreach ($approvers as $approver) {
            array_push($users, json_decode($approver->getUser($approver['user_id'])));
        }
        return response($users, 200);
    }

    /**
     * Return an array of users
     */
    public function listContacts()
    {
        $users = User::all();
        return response($users, 200);
    }

    /**
     * Return an array of rooms
     */
    public function listRooms(String $id)
    {
        $rooms = Room::where('plant_id', $id)->get();
        return response($rooms, 200);
    }

    /**
     * Return an array of services
     */
    public function listServices()
    {
        $services = ServiceType::all();
        return response($services, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $companies = Company::all();
        return view('requests.create',compact('roles', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'company' => 'required',
            'plant' => 'required',
            'costCenter' => 'required',
            'contact' => 'required',
            'reason' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'room' => 'required',
            'services' => 'required',
            'canInterrup' => 'required',
            'persons' => 'required'
        ]);

        $inputs = $request->all();

        if ($inputs['type'] === 'Save') {
            $status = Status::where('name', 'Draft')->first();
        } else {
            $status = Status::where('name', 'Pending')->first();
        }

        $query = [
            '_token' => $inputs['_token'],
            'invoice_code' => 34,
            'request_num' => 45,
            'company_id' => $inputs['company'],
            'plant_id' => $inputs['plant'],
            'cost_center_id' => $inputs['costCenter'],
            'user_id' => Auth::id(),
            'status_id' => $status->id,
            'contact_id' => $inputs['contact'],
            'reason' => $inputs['reason'],
            'start_date' => new DateTime($inputs['start_date']),
            'end_date' => new DateTime($inputs['end_date']),
            'room_id' => $inputs['room'],
            'can_interrump' => $inputs['canInterrup'],
            'content' => $inputs['content'],
            'number_persons' => $inputs['persons']
        ];

        UserRequest::create($query);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function show(UserRequest $userRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRequest $userRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserRequest $userRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRequest $userRequest)
    {
        //
    }
}
