<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>ISCAPSGT09</title>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}">
		@yield('css')
	</head>
	<body>
		<div class="">
			<div class="black-header">
				@if (!Auth::guest())
					<div class="text-right">
						<a href="{{ url('/logout') }}" class="bigger"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
					</div>
				@endif
				@yield('header')
			</div>
			@yield('errors')

			@if (Session::has('success'))
				<div class="alert alert-success">
					{{ Session::get('success') }}
				</div>
			@endif
			@yield('content')
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="{{ asset('/js/class.js') }}"></script>
		@yield('js')
	</body>
</html>