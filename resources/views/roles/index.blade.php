@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 d-flex mb-3">
        <div class="col-lg-10">
            <h2>{{ __('Manage Roles') }}</h2>
        </div>
        <div class="col-lg-2">
        @can('role-create')
            <a class="btn btn-outline-primary" href="{{ route('roles.create') }}">{{ __('Create New Role') }}</a>
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
            <th>{{ __('Name')}}</th>
            <th width="280px">{{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($roles as $key => $role)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <a class="btn btn-outline-secondary" href="{{ route('roles.show',$role->id) }}">{{ __('Show') }}</a>
                    @can('role-edit')
                        <a class="btn btn-outline-primary" href="{{ route('roles.edit',$role->id) }}">{{ __('Edit') }}</a>
                    @endcan
                    @can('role-delete')
                        {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                            {!! Form::submit(__('Delete'), ['class' => 'btn btn-outline-danger']) !!}
                        {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{!! $roles->render() !!}

@endsection