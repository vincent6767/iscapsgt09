@extends('layouts.master')

@section('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/userinformation.css') }}">
@endsection

@section('header')
	<div class="bigger text-center white-title">
		<h1>
			<strong>ISCAPS</strong>
			<img id="iscaps-logo" src="{{ asset('/images/LOGOMEONG.png') }}" alt="iscaps logo">
		</h1>
	</div> 
	<div id="iscaps-abbreviation" class="bigger text-center">
		<p>INTEGRATED AND SMART AIR</p>
		<p>PURIFYING SYSTEM</p>
	</div>
	<div id="motivational-quotes" class="white-title bigger center quotes">
		<p>"Pedalling with ISCAPS twice every day will bring about healthier life for you"</p>
	</div>
@endsection

@section('content')
	<div class="content"> 
		{!! Form::model($user, ['url' => url(''), 'method' => 'POST']) !!}
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<div class="form-group">
						{!! Form::label('gender', '*GENDER: ', ['class' => 'control-label bigger']) !!}
						{!! Form::select('gender', array('f' => 'Female','m' => 'Male'), null, ['class' => 'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('age', '*AGE (Years): ', ['class' => 'control-label bigger']) !!}
						{!! Form::number('age', Request::old('age'), ['class' => 'form-control', 'id' => 'age']) !!}
						<span class="help-block" id="age-error"></span>		
					</div>
					<div class="form-group">
						{!! Form::label('weight', '*WEIGHT (kg): ', ['class' => 'control-label bigger']) !!}
						{!! Form::number('weight', Request::old('weight'), ['class' => 'form-control', 'id' => 'weight']) !!}
						<span class="help-block" id="weight-error">

						</span>
					</div>
				</div>
				<div class="col-sm-12 col-md-6">
					<div class="text-center">
						{!! Form::label('speedometer', 'HOW FAST YOU CAN GO: ', ['class' => 'control-label bigger']) !!}
					</div>
					<div id="speedometer">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 col-md-6">
					<div class="form-group">
						{!! Form::label('calories', 'Calories (cal): ', ['class' => 'control-label bigger']) !!}
						{!! Form::number('calories', 0, ['class' => 'form-control', 'readonly' => true]) !!}
					</div>
				</div>
				<div class="col-sm-12 col-md-6">
					<div class="form-group">
						{!! Form::label('points', 'Points earned: ', ['class' => 'control-label bigger']) !!}
						{!! Form::number('points', $user->points, ['class' => 'form-control', 'readonly' => true]) !!}
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@endsection

@section('js')
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts-more.js"></script>
	<!-- <script type="text/javascript" src="https://code.highcharts.com/modules/exporting.js"></script> -->
	<script type="text/javascript" src="{{ asset('/js/speedometer.js') }}"></script>

	<script type="text/javascript">
		session = new CyclingSession({{ $session->id }}, '{{ $session->start_time }}');
		
		user = new User({{ $user->age }}, {{ $user->weight }}, {{ $user->points }}, '{{ $user->gender }}', session);
		
		view = new UserInformationView($('#speedometer').highcharts());

		calculator = new CaloriesCalculator(user);

		controller = new UserInformationController(view, user, calculator, '{{ url('/session-stop') }}');

		controller.initialize();

		controller.polling('{{ url('/get-updates') }}', 1000);
	</script>
@endsection