@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 d-flex mb-2">
        <div class="col-lg-10">
            <h2>{{ __('Create New User') }}</h2>
        </div>
        <div class="col-lg-2">
            <a class="btn btn-outline-primary" href="{{ route('users.index') }}">{{__('Back') }}</a>
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

{!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
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
                <strong>{{ __('E-Mail Address') }}:</strong>
                {!! Form::text('email', null, array('placeholder' => __('E-Mail Address'),'class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('Password') }}:</strong>
                {!! Form::password('password', array('placeholder' => __('Password'),'class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('Confirm Password') }}:</strong>
                {!! Form::password('confirm-password', array('placeholder' => __('Confirm Password'),'class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{ __('Role') }}:</strong>
                {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
        </div>
    </div>
</div>
{!! Form::close() !!}

@endsection