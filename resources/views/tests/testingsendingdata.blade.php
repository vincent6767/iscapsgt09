@extends('layouts.master')

@section('header')
	<h2 class="text-center">ISCAPS GT09</h2>
	<h3 class="text-center">Testing Sending Data Page</h3>
	<h4 class="text-center">Happy birthday robert tan!</h4>
@endsection

@section('content')
	<div class="container">
		<div id="test-output">

		</div>
	</div>
@endsection

@section('js')
	<script type="text/javascript">
		view = new TestSendingDataView();

		controller = new TestingCyclingController(view);

		controller.startPolling('{{ action('TestingCyclingController@testGetUpdates') }}', 1000);
	</script>
@endsection
