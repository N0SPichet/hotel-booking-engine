@extends ('manages.main')
@section ('title', 'Administrator | Apartment')

@section ('content')
<div class="container">
	<div class="row col m-t-10">
		<div class="card col">
			<div class="card-title"><h1 class="title-page">Apartments</h1></div>
			@if (session('alert'))
			    <div class="alert alert-success">
			        {{ session('alert') }}
			    </div>
			@endif
			<div class="card-body">
				@if($houses->count())
				@foreach($houses as $house)
					<div class="card">
						<div class="margin-content">
							<div class="col-md-9 float-left">
								<a href="{{ route('rooms.owner', $house->id) }}" style="text-decoration-line: none;">
								<p><b>Title</b> : {{ $house->house_title }} </p>
								<p><b>Created by</b> : {{ $house->user->user_fname }} {{ $house->user->user_lname }}</p>
								<p>Date Create : {{ date("jS F, Y", strtotime($house->created_at)) }}</p>
								</a>
							</div>

							<div class="col-md-3 float-left" align="center">
								{!! Html::linkRoute('rooms.owner', 'View room detail', array($house->id), array('class' => 'btn btn-info btn-sm', 'style' => 'width: 60%')) !!}

								@if (Auth::user()->id == $house->user_id)

								{!! Form::open(['route' => ['rooms.destroy', $house->id], 'method' => 'DELETE']) !!}
								
								{!! Form::submit('Delete this room', ['class' => 'btn btn-danger btn-sm m-t-20', 'style' => 'width: 60%']) !!}

								{!! Form::close() !!}
								@endif
							</div>
						</div>
					</div>
				@endforeach
				@else
				<h4>No result</h4>
				@endif
			</div>
		</div>
		<div class="text-center">
			{!! $houses->links() !!}
		</div>
	</div>
</div>
@endsection
