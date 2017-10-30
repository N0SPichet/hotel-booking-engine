@extends('main')

@section('title','About' . ' ' . $user->user_fname)

@section('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading"><h4>About {{ $user->user_fname }}</h4></div>

			<div class="panel-body">
				<p>{{ $user->user_description }}</p>
			</div>
		</div>
		
	</div>
</div>
@endsection