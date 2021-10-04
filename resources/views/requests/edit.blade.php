@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex mb-2">
            <div class="col-lg-10">
                <h2>{{ __('Edit Request') }}</h2>
            </div>
            <div class="col-lg-2">
                @can('request-list')
                <a class="btn btn-outline-primary" href="{{ route('requests.index') }}">{{ __('Back') }}</a>
                @endcan
            </div>
        </div>
    </div>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong>{{ __(' There were some problems with your input.') }}<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<edit-request-component
    csrf-token="{{ csrf_token() }}"
    requestor="{{ $request->getUser($request->user_id)->name }}"
    back="{{ route('requests.index') }}"
    update="{{ route('requests.update', $request->id) }}"
    request-id="{{ $request->id }}"
    company-value="{{ $request->company_id }}"
    plant-value="{{ $request->plant_id }}"
    cost-center-value="{{ $request->cost_center_id }}"
    reason-value="{{ $request->reason }}"
    contact-value="{{ $request->contact_id }}"
    room-value="{{ $request->room_id }}"
    content-value="{{ $request->content }}"
    persons-value="{{ $request->number_persons }}"
    interrump="{{ $request->can_interrump }}"
    selected-services="{{ $services }}"
    start="{{ $request->start_date }}"
    end="{{ $request->end_date }}"
    status="{{ $request->getStatus($request->status_id)->name }}"
></edit-request-component>

@endsection