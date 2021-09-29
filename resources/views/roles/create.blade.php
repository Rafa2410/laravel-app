@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 d-flex mb-2">
        <div class="col-lg-10">
            <h2>{{ __('Create New Role') }}</h2>
        </div>
        <div class="col-lg-2">
            <a class="btn btn-outline-primary" href="{{ route('roles.index') }}">{{ __('Back') }}</a>
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

{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('Name') }}:</strong>
                {!! Form::text('name', null, array('placeholder' => __('Name'),'class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('Permissions') }}:</strong>
                <br/>
                @foreach($permission as $value)
                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                    {{ $value->name }}</label>
                <br/>
                @endforeach
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection