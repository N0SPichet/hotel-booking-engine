@extends ('main')

@section ('title', 'Administrator | Rooms')

@section ('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default col">
			<div class="panel-heading"><h1 class="title-page">Rooms</h1></div>
			@if (session('alert'))
			    <div class="alert alert-success">
			        {{ session('alert') }}
			    </div>
			@endif
			<div class="panel-body">
				@foreach($houses as $house)
					<div class="card margin-top-10">
						<div class="margin-content">
							<div class="col-md-9">
								<a href="{{ route('rooms.single', $house->id) }}" style="text-decoration-line: none;">
								<p><b>Title</b> : {{ $house->house_title }} </p>
								<p><b>Created by</b> : {{ $house->users->user_fname }} {{ $house->users->user_lname }}</p>
								<p>Date Create : {{ date("jS F, Y", strtotime($house->created_at)) }}</p>
								</a>
							</div>

							<div class="col-md-3" align="center">
								{!! Html::linkRoute('rooms.single', 'View room detail', array($house->id), array('class' => 'btn btn-info btn-sm', 'style' => 'width: 60%')) !!}

								@if ($house->users_id == Auth::user()->id)

								{!! Form::open(['route' => ['rooms.destroy', $house->id], 'method' => 'DELETE']) !!}
								
								{!! Form::submit('Delete this room', ['class' => 'btn btn-danger btn-sm btn-h1-spacing', 'style' => 'width: 60%']) !!}

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
			<!-- generate link for houses item -->
			{!! $houses->links() !!}
		</div>
	</div>
</div>

@endsection