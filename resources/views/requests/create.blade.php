@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex mb-2">
            <div class="col-lg-10">
                <h2>{{ __('Requests') }}</h2>
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

{!! Form::open(array('route' => 'requests.store','method'=>'POST')) !!}
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="name">{{ __('Name') }}:</label>
                <input type="text" id="name" class="@error('name') is-invalid @enderror form-control" value="{{ Auth::user()->name }}">
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="company">{{ __('Company') }}:</label>
                    <select class="form-control" id="company">
                        <option value="">{{ __('Select Company') }}</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection