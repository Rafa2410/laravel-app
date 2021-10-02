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

<create-request-component
    csrf-token="{{ csrf_token() }}"
    requestor="{{ Auth::user()->name }}"
></create-request-component>

@endsection