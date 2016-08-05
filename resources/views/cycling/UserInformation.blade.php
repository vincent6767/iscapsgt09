@extends('layouts.master')

@section('content')
	This page has not been built! In case you forgot where is the testing page, <a href="{{ action('TestingCyclingController@testShowTestingSendingDataPage') }}">click this!</a>

	{!! Form::model($user, ['url' => url(''), 'method' => 'POST', 'class' => 'form-horizontal']) !!}
		
	{!! Form::close() !!}
@endsection