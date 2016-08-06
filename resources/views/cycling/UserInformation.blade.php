@extends('layouts.master')

@section('errors')

@endsection

@section('content')
	{!! Form::model($user, ['url' => url(''), 'method' => 'POST', 'class' => 'form-horizontal']) !!}
		<div class="form-group">
			{!! Form::label('gender', 'Gender: ', ['class' => 'control-label col-sm-4']) !!}
			<div class="radio col-sm-4">
				<label class="control-label radio-inline"><input type="radio" name="gender" value="m" {{ $user->is('m') ? 'checked' : '' }}>Male</label>
				<label class="control-label radio-inline"><input type="radio" name="gender" value="f" {{ $user->is('f') ? 'checked' : '' }}>Female</label>
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('age', 'Age: ', ['class' => 'control-label col-sm-4']) !!}
			<div class="col-sm-8"> 
				{!! Form::number('age', Request::old('age'), ['class' => 'form-control', 'id' => 'age']) !!}
				<span class="help-block" id="age-error">

				</span>
			</div>
			
		</div>
		<div class="form-group">
			{!! Form::label('weight', 'Weight: ', ['class' => 'control-label col-sm-4']) !!}
			<div class="col-sm-4"> 
				{!! Form::number('weight', Request::old('weight'), ['class' => 'form-control', 'id' => 'weight']) !!}
				<span class="help-block" id="weight-error">

				</span>
			</div>
			
		</div>
		<div class="form-group">
			{!! Form::label('rpm', 'RPM: ', ['class' => 'control-label col-sm-4']) !!}
			<div class="col-sm-4"> 
				{!! Form::number('rpm', 0, ['class' => 'form-control', 'readonly' => true]) !!}
			</div>
		</div>

		<!-- Speedometer Container -->
		<div class="container speedometer-container" id="speedometer">
		</div>

		<div class="form-group">
			{!! Form::label('calories', 'Calories: ', ['class' => 'control-label col-sm-4']) !!}
			<div class="col-sm-4"> 
				{!! Form::number('calories', 0, ['class' => 'form-control', 'readonly' => true]) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('points', 'Points earned: ', ['class' => 'control-label col-sm-4']) !!}
			<div class="col-sm-4"> 
				{!! Form::number('points', $user->points, ['class' => 'form-control', 'readonly' => true]) !!}
			</div>
		</div>
	{!! Form::close() !!}
@endsection

@section('js')
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts-more.js"></script>
	<script type="text/javascript" src="https://code.highcharts.com/modules/exporting.js"></script>
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