@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex mb-2">
            <div class="col-lg-10">
                <h2>{{ __('Request') }}</h2>
            </div>
            <div class="col-lg-2">
                @can('request-list')
                <a class="btn btn-outline-primary" href="{{ route('requests.index') }}">{{ __('Back') }}</a>
                @endcan
            </div>
        </div>
    </div>

    <div class="container-fluid mt-3">
        <div class="col-lg-8 mx-auto">
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="company">{{ __('Company') }}</label>
                        <input type="text" class="form-control" id="company" value="{{ $request->getCompany($request->company_id)->name }}" readonly />
                    </div>
                    <div class="col-6">
                        <label for="plant">{{ __('Plant') }}</label>
                        <input type="text" class="form-control" id="plant" value="{{ $request->getPlant($request->plant_id)->name }}" readonly />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="cost_center">{{ __('Cost Center') }}</label>
                        <input type="text" class="form-control" id="cost_center" value="{{ $request->getCostCenter($request->cost_center_id)->name }}" readonly />
                    </div>
                    <div class="col-6">
                        <label for="room">{{ __('Room') }}</label>
                        <input type="text" class="form-control" id="room" value="{{ $request->getRoom($request->room_id)->name }}" readonly />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="requestor">{{ __('Requestor') }}</label>
                        <input type="text" class="form-control" id="requestor" value="{{ $request->getUser($request->user_id)->name }}" readonly />
                    </div>
                    <div class="col-6">
                        <label for="contact">{{ __('Contact Name') }}</label>
                        <input type="text" class="form-control" id="contact" value="{{ $request->getUser($request->contact_id)->name }}" readonly />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="reason">{{ __('Reason') }}</label>
                        <textarea type="text" class="form-control" id="reason" readonly>{{ $request->reason }}</textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="start_date" style="width: 100%; padding-left: 15px;">{{ __('Start Date') }}</label>
                    <div class="col-6">
                        <input type="date" class="form-control" id="start_date" value="{{ explode(' ', $request->start_date)[0] }}" readonly />
                    </div>
                    <div class="col-6">
                        <input type="time" class="form-control" value="{{ explode(' ', $request->start_date)[1] }}" readonly />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="end_date" style="width: 100%; padding-left: 15px;">{{ __('End Date') }}</label>
                    <div class="col-6">
                        <input type="date" class="form-control" id="end_date" value="{{ explode(' ', $request->end_date)[0] }}" readonly />
                    </div>
                    <div class="col-6">
                        <input type="time" class="form-control" value="{{ explode(' ', $request->end_date)[1] }}" readonly />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="interrupt" style="width: 100%; padding-left: 15px;">{{ __('Can it be interrupted?') }}</label>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="interruptRadio" id="interruptRadio1" value="yes" checked="{{ $request->can_interrump === '1' ? true : false }}" disabled>
                            <label class="form-check-label" for="interruptRadio1">
                                {{ __('Yes') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="interruptRadio" id="interruptRadio2" value="no" checked="{{ $request->can_interrump === '0' ? true : false }}" disabled>
                            <label class="form-check-label" for="interruptRadio2">
                                {{ __('No') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="services">{{ __('Service Type') }}</label>
                        <input type="text" class="form-control" id="services" value="{{ $request->getServices($request->id) }}" readonly />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="req_content">{{ __('Content') }}</label>
                        <input type="text" class="form-control" id="req_content" value="{{ $request->content }}" readonly />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="persons">{{ __('Persons') }}</label>
                        <input type="number" class="form-control" id="persons" value="{{ $request->number_persons }}" readonly />
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection