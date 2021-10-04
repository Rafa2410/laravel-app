@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex mb-2">
            <div class="col-lg-10">
                <h2>{{ __('Requests') }}</h2>
            </div>
            <div class="col-lg-2">
                @can('request-create')
                <a class="btn btn-outline-primary" href="{{ route('requests.create') }}">{{ __('Create New Request') }}</a>
                @endcan
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <script type="application/javascript">
            setTimeout(() => {
                document.getElementById('alert').style.display = 'none';
            }, 2000);
        </script>
        <div class="alert alert-success" id="alert">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-hover">
        <thead>
            <tr>
                <th>{{ __('Company') }}</th>
                <th>{{ __('Request Num') }}</th>
                <th>{{ __('Requestor') }}</th>
                <th>{{ __('Room') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Date') }}</th>
                <th>{{ __('Services') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @if (count($data) === 0)
                <tr class="text-center">
                    <td colspan="8">{{ __('Not any request yet') }}</td>
                </tr>
            @else
                @foreach ($data as $key => $req)
                    <tr class="{{ $req->getStatus($req->status_id)->name !== 'Draft' && $req->getStatus($req->status_id)->name !== 'Pending' ? 'managed' : '' }}">
                        <td>{{ $req->getCompany($req->company_id)->name }}</td>
                        <td>{{ $req->request_num }}</td>
                        <td>{{ $req->getUser($req->user_id)->name }}</td>
                        <td>{{ $req->getRoom($req->room_id)->name }}</td>
                        <td>{{ __($req->getStatus($req->status_id)->name) }}</td>
                        <td>{{ $req->start_date }}</td>
                        <td class="truncate">{{ $req->getServices($req->id) }}</td>
                        <td style="max-width: 200px;">
                            @can('request-edit')
                                @if ($req->getStatus($req->status_id)->name === 'Draft' && !@Auth::user()->hasRole('Approver'))
                                    <a class="btn btn-outline-primary" href="{{ route('requests.edit',$req->id) }}">{{ __('Edit') }}</a>
                                @elseif (@Auth::user()->hasRole('Approver'))
                                    <a class="btn btn-outline-primary" href="{{ route('manage-request',$req->id) }}">{{ __('Manage') }}</a>
                                @endif
                            @endcan
                            @can('request-delete')
                                {!! Form::open(['method' => 'DELETE','route' => ['requests.destroy', $req->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit(__('Delete'), ['class' => 'btn btn-outline-danger']) !!}
                                {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

@endsection