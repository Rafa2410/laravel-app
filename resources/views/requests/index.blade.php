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
        <div class="alert alert-success">
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
            @foreach ($data as $key => $req)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $req->getCompany($req->company_id)->name }}</td>
                    <td>{{ $req->getPlant($req->plant_id)->name }}</td>
                    <td>{{ $req->getCostCenter($req->cost_center_id)->name }}</td>
                    <td>{{ __($req->getStatus($req->status_id)->name) }}</td>
                    <td>{{ $req->start_date }}</td>
                    <td>{{ $req->end_date }}</td>
                    <td>
                    @can('request-edit')
                        <a class="btn btn-outline-primary" href="{{ route('requests.edit',$req->id) }}">{{ __('Edit') }}</a>
                    @endcan
                    @can('request-delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['requests.destroy', $req->id],'style'=>'display:inline']) !!}
                            {!! Form::submit(__('Delete'), ['class' => 'btn btn-outline-danger']) !!}
                        {!! Form::close() !!}
                    @endcan
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection