@extends ('main')

@section ('title', 'Administrator | Rooms')

@section ('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading"><h1>Rooms</h1></div>
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
								<p>#ID {{ $house->id }}</p>
								<p>Title : {{ $house->house_title }} </p>
								<p>Created by : {{ $house->users->user_fname }} {{ $house->users->user_lname }}</p>
								<p>Created at : {{ date("jS F, Y", strtotime($house->created_at)) }}</p>
							</div>

							<div class="col-md-2 col-md-offset-1">
								{!! Html::linkRoute('rooms.single', 'View room detail', array($house->id), array('class' => 'btn btn-info btn-sm btn-block')) !!}

								@if ($house->users_id == Auth::user()->id)

								{!! Form::open(['route' => ['rooms.destroy', $house->id], 'method' => 'DELETE']) !!}
								
								{!! Form::submit('Delete this room', ['class' => 'btn btn-danger btn-sm btn-block btn-h1-spacing']) !!}

								{!! Form::close() !!}
								@endif
							</div>
						</div> <!-- end of col-md-12 -->
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