@extends ('dashboard.main')
@section ('title', 'Your Apartment')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('dashboard.hosts.index') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="card col">
			<div class="card-title"><h1>Your Apartments</h1></div>
			@if (session('alert'))
			    <div class="alert alert-success">
			        {{ session('alert') }}
			    </div>
			@endif
			<div class="card-body">
				@if ($houses->count())
				@foreach($houses as $key => $house)
				<div class="row m-t-10">
					<div class="col-md-12">
						<div class="col-md-10 float-left">
							<a href="{{ route('apartments.owner', $house->id) }}" style="text-decoration-line: none;">
							<p>
								@if ($house->publish == '2')
								<span class="text-danger"><i class="fas fa-trash"></i> Trash</span>
								@elseif ($house->publish == '1')
								<span class="text-success"><i class="fas fa-eye"></i> Published</span>
								@elseif ($house->publish == '0')
								<span class="text-danger"><i class="fas fa-eye-slash"></i> Private</span>
								@endif
								<b>Title</b> : {{ $house->house_title }} - {{ $house->sub_district->name }} {{ $house->district->name }}, {{ $house->province->name }}
							</p>
							<p>Date : {{ date("jS F, Y", strtotime($house->created_at)) }} (last update {{ $house->updated_at->diffForHumans() }})</p>
							</a>
						</div>
						<div class="col-md-2 float-left">
							{!! Html::linkRoute('apartments.owner', 'View room detail', array($house->id), array('class' => 'btn btn-info btn-sm btn-block')) !!}
						</div>
					</div>
				</div>
				@if ($houses->count() != $key+1)
				<hr>
				@endif
				@endforeach
				@else
				<p>Create new one</p>
				<a href="{{ route('apartments.create') }}" class="btn btn-danger m-t-10 poll-right">Create Apartment</a>
				@endif
			</div>
		</div>
		<div class="text-center">
			{!! $houses->links() !!}
		</div>
	</div>
</div>

@endsection
