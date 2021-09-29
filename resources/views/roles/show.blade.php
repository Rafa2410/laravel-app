@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 d-flex mb-3">
        <div class="col-lg-12">
            <a class="btn btn-outline-primary" href="{{ route('roles.index') }}">{{ __('Back') }}</a>
        </div>
    </div>
</div>

<div class="container-fluid mt-3">
    <div class="row text-center">
        <div class="col-lg-12">
            <div class="form-group">
                <p>
                    <span class="h4">{{ __('Name') }}:</span>
                    <span class="h3 text-muted">{{ $role->name }}</span>
                </p>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-group">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('Permissions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($rolePermissions))
                            @foreach($rolePermissions as $v)
                                <tr><td>{{ $v->name }}</td><tr/>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection