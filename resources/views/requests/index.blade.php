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
                <th>{{ __('Id') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Name') }} 2</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $req)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $req->user_id }}</td>
                    <td>{{ $req->getUser($req->user_id)->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection