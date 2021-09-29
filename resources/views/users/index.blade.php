@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-lg-12 d-flex mb-3">
        <div class="col-lg-10">
            <h2>{{ __('Manage Users')}}</h2>
        </div>
        <div class="col-lg-2">
            <a class="btn btn-outline-primary" href="{{ route('users.create') }}">{{ __('Create New User') }}</a>
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
      <th>{{ __('E-Mail Address') }}</th>
      <th>{{ __('Roles') }}</th>
      <th width="280px">{{ __('Action') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $key => $user)
      <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
          @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
              <label class="badge badge-primary">{{ $v }}</label>
            @endforeach
          @endif
        </td>
        <td>
          <a class="btn btn-outline-secondary" href="{{ route('users.show',$user->id) }}">{{ __('Show') }}</a>
          <a class="btn btn-outline-primary" href="{{ route('users.edit',$user->id) }}">{{ __('Edit') }}</a>
            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                {!! Form::submit(__('Delete'), ['class' => 'btn btn-outline-danger']) !!}
            {!! Form::close() !!}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

{!! $data->render() !!}

@endsection