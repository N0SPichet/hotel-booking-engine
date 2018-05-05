@extends ('main')

@section ('title', 'Your Apartment')

@section ('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default col">
			<div class="panel-heading"><h1>Your Apartments</h1></div>
			@if (session('alert'))
			    <div class="alert alert-success">
			        {{ session('alert') }}
			    </div>
			@endif
			<div class="panel-body">
				@foreach($houses as $house)
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-8">
							<a href="{{ route('rooms.single', $house->id) }}" style="text-decoration-line: none;">
							<p><b>Title</b> : {{ $house->house_title }} </p>
							<p>Date Create : {{ date("jS F, Y", strtotime($house->created_at)) }}</p>
							</a>
						</div>
						<div class="col-md-2 col-md-offset-1">
							{!! Html::linkRoute('apartments.single', 'View room detail', array($house->id), array('class' => 'btn btn-info btn-sm btn-block')) !!}
							@if ($house->users_id == Auth::user()->id)
							{!! Form::open(['route' => ['apartments.destroy', $house->id], 'method' => 'DELETE']) !!}
							{!! Form::submit('Delete this room', ['class' => 'btn btn-danger btn-sm btn-block btn-h1-spacing']) !!}
							{!! Form::close() !!}
							@endif
						</div>
					</div>
				</div>
				<hr>
				@endforeach
			</div>
		</div>
		<div class="text-center">
			{!! $houses->links() !!}
		</div>
	</div>
</div>

@endsection