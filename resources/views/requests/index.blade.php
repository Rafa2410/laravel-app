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
                <th>{{ __('Request Num') }}</th>
                <th>{{ __('Company') }}</th>
                <th>{{ __('Plant') }}</th>
                <th>{{ __('Cost Center') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Start Date') }}</th>
                <th>{{ __('End Date') }}</th>
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
                    <tr class="{{ $req->getStatus($req->status_id)->name === 'Cancelled' ? 'cancelled' : '' }}">
                        <td>{{ $req->request_num }}</td>
                        <td>{{ $req->getCompany($req->company_id)->name }}</td>
                        <td>{{ $req->getPlant($req->plant_id)->name }}</td>
                        <td>{{ $req->getCostCenter($req->cost_center_id)->name }}</td>
                        <td>{{ __($req->getStatus($req->status_id)->name) }}</td>
                        <td>{{ $req->start_date }}</td>
                        <td>{{ $req->end_date }}</td>
                        <td>
                        @can('request-edit')
                            @if ($req->getStatus($req->status_id)->name !== 'Cancelled')
                            <a class="btn btn-outline-primary" href="{{ route('requests.edit',$req->id) }}">{{ __('Edit') }}</a>
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