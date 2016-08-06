@extends('layouts.master')

@section('js')
	<script type="text/javascript">
		view = new TestSendingDataView();
		controller = new TestingCyclingController(view);

		controller.posting('{{ url('/cycling') }}', 1000);
		
	</script>

@endsection