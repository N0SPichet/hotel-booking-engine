@if(Session::has('success'))
	<div class="alert alert-success" role="alert">
		<strong>Success:</strong> {{ Session::get('success') }}
	</div>
@endif

@if(Session::has('fail'))
	<div class="alert alert-danger" role="alert">
		<strong>Fail:</strong> {{ Session::get('fail') }}
	</div>
@endif