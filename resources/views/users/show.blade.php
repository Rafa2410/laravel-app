@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 d-flex mb-3">
        <div class="col-lg-12">
            <a class="btn btn-outline-primary" href="{{ route('users.index') }}">{{ __('Back') }}</a>
        </div>
    </div>
</div>

<div class="container-fluid text-center">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <p>
                    <span class="h4">{{ __('Name') }}: </span>
                    <span class="h3 text-muted">{{ $user->name }}</span>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <p>
                    <span class="h4">{{ __('E-Mail Address') }}: </span>
                    <span class="h3 text-muted">{{ $user->email }}</span>
                </p>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <span class="h4">{{ __('Roles') }}: </span>
                @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                        <label class="badge badge-primary">{{ $v }}</label>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection