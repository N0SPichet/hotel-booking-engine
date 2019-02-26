@extends ('main')

@section ('title', 'Your Rooms')

@section ('content')

<div class="container">
	<div class="row m-t-10">
		<div class="card col">
			<div class="card-title"><h1>Your Rooms</h1></div>
			@if (session('alert'))
			    <div class="alert alert-success">
			        {{ session('alert') }}
			    </div>
			@endif
			<div class="card-body">
				@if($houses->count())
				@foreach($houses as $house)
				<div class="row m-t-10">
					<div class="col-md-12">
						<div class="col-md-10 float-left">
							<a href="{{ route('rooms.owner', $house->id) }}" style="text-decoration-line: none;">
							<p><b>Title</b> : {{ $house->house_title }} </p>
							<p>Date Create : {{ date("jS F, Y", strtotime($house->created_at)) }}</p>
							</a>
						</div>
						<div class="col-md-2 float-left">
							{!! Html::linkRoute('rooms.owner', 'View room detail', array($house->id), array('class' => 'btn btn-info btn-sm btn-block')) !!}
							@if ($house->users_id == Auth::user()->id)
							{!! Form::open(['route' => ['rooms.destroy', $house->id], 'method' => 'DELETE']) !!}
							{!! Form::submit('Delete this room', ['class' => 'btn btn-danger btn-sm btn-block btn-h1-spacing']) !!}
							{!! Form::close() !!}
							@endif
						</div>
					</div>
				</div>
				@endforeach
				@else
				<p>Create new one</p>
				<a href="{{ route('rooms.create') }}" class="btn btn-danger m-t-10 pull-right">Create Room</a>
				@endif
			</div>
		</div>
		<div class="text-center">
			{!! $houses->links() !!}
		</div>
	</div>
</div>

@endsection