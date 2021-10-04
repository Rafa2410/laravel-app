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
use App\Models\RequestHasService;
use App\Models\RequestHasApprover;
use DateTime;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestApproved;
use App\Mail\RequestSimpleTemplate;

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
        $user = User::find(@Auth::user()->id);
        if ($user->hasRole('Admin')) {
            $data = UserRequest::orderBy('id','DESC')->paginate()->all();
        } else if ($user->hasRole('Approver')) {
            $allRequests = RequestHasApprover::where('user_id', $user->id)->get();
            $approverRequests = [];
            foreach ($allRequests as $req) {
                array_push($approverRequests, $req->user_request_id);
            }
            $data = UserRequest::orderBy('id','DESC')->paginate()
                    ->where('status_id', '>', 1)
                    ->whereIn('id', $approverRequests);
        } else {
            $data = UserRequest::orderBy('id','DESC')->paginate()
                    ->where('user_id', Auth::id());
        }

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

        $status = Status::where('name', $inputs['type'])->first();

        $num = UserRequest::count() + 1;
        $seq = '';
        for ($i=strlen(strval($num)); $i < 4; $i++) { 
            $seq = $seq . '0';
        }
        $seq = now()->year . now()->month . $seq . $num;

        $query = [
            '_token' => $inputs['_token'],
            'invoice_code' => $inputs['plant'].$inputs['costCenter'],
            'request_num' => intval($seq),
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

        $userRequest = UserRequest::create($query);

        foreach ($inputs['services'] as $service) {
            RequestHasService::create([
                'user_request_id' => $userRequest->id,
                'service_types_id' => $service
            ]);
        }

        foreach ($inputs['approvers'] as $approver) {
            RequestHasApprover::create([
                'user_request_id' => $userRequest->id,
                'user_id' => $approver['id']
            ]);
        }

        if ($status->name === 'Pending') {
            $this->sendMail($status->name, UserRequest::find($userRequest->id));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function show(UserRequest $userRequest, $id)
    {
        $request = UserRequest::find($id);
        return view('requests.show', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $request = UserRequest::find($id);
        $services = RequestHasService::where('user_request_id', $request->id)->get();

        return view('requests.edit', compact('request', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'company' => 'required',
            'plant' => 'required',
            'center' => 'required',
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
        
        $status = Status::where('name', $inputs['type'])->first();

        $query = [
            '_token' => $inputs['_token'],
            'company_id' => $inputs['company'],
            'plant_id' => $inputs['plant'],
            'cost_center_id' => $inputs['center'],
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

        $userRequest = UserRequest::find($inputs['id']);
        $userRequest->update($query);

        RequestHasService::where('user_request_id', $userRequest->id)->delete();

        foreach ($inputs['services'] as $service) {
            RequestHasService::create([
                'user_request_id' => $userRequest->id,
                'service_types_id' => $service
            ]);
        }

        RequestHasApprover::where('user_request_id', $userRequest->id)->delete();

        foreach ($inputs['approvers'] as $approver) {
            RequestHasApprover::create([
                'user_request_id' => $request->id,
                'user_id' => $approver['id']
            ]);
        }
    }

    /**
     * Update state to a request
     */
    public function changeState(Request $request, $id) {
        $this->validate($request, [
            'type' => 'required',
        ]);

        $inputs = $request->all();
        $status = Status::where('name', $inputs['type'])->first();

        $query = [
            'status_id' => $status->id,
        ];
        
        $userRequest = UserRequest::find($id);
        $userRequest->update($query);

        $this->sendMail($status->name, $userRequest);
    }

    function sendMail(String $status, UserRequest $userRequest)
    {
        switch ($status) {
            case 'Pending':
                $approvers = RequestHasApprover::where('user_request_id', $userRequest->id)->get();
                $approversEmails = [];
                foreach ($approvers as $approver) {
                    array_push($approversEmails, $approver->getUser($approver->user_id)->email);
                }
                Mail::to($approversEmails) 
                    ->send(new RequestSimpleTemplate(
                        $userRequest,
                        __('New catering request')." (".$userRequest->getCompany($userRequest->company_id)->name.")",
                        __('A new catering request has been created for').$userRequest->getCompany($userRequest->company_id)->name."."
                    ));
                break;
            case 'Rejected':
                Mail::to($userRequest->getUser($userRequest->user_id)->email)
                    ->send(new RequestSimpleTemplate(
                        $userRequest,
                        __('Catering request rejected'),
                        __('The catering request has been rejected')
                    ));
                break;
            case 'Approved':
                $emails = [];
                array_push($emails, $userRequest->getUser($userRequest->user_id)->email);
                array_push($emails, 'cocina@cocinaficosa.com');
                Mail::to($emails) 
                    ->send(new RequestApproved(
                        $userRequest,
                        __('Catering request')
                    ));
                break;
            case 'Cancelled':
                $emails = [];
                array_push($emails, $userRequest->getUser($userRequest->user_id)->email);
                array_push($emails, 'cocina@cocinaficosa.com');
                Mail::to($emails) 
                    ->send(new RequestSimpleTemplate(
                        $userRequest,
                        __('Catering request cancelled'),
                        __('The catering request has been cancelled')
                    ));
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRequest  $userRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserRequest::find($id)->delete();
        return redirect()->route('requests.index')
            ->with('success', __('Request deleted successfully'));
    }

    /**
     * Get user request and open approver view to manage request
     */
    public function manage(Request $request, $id)
    {
        $request = UserRequest::find($id);
        $services = RequestHasService::where('user_request_id', $request->id)->get();

        return view('requests.manage', compact('request', 'services'));
    }
}
