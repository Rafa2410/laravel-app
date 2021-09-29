@extends('layouts.app')

@section('content')
<h2>Peticiones</h2>
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