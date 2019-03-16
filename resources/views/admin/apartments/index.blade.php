@extends ('admin.layouts.app')
@section ('title', 'Apartment')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
		</div>
	</div>
	<div class="row col m-t-10">
		<div class="card col">
			<div class="card-title"><h1 class="title-page">Apartments</h1></div>
			@if (session('alert'))
			    <div class="alert alert-success">
			        {{ session('alert') }}
			    </div>
			@endif
			<div class="row" align="center">
				<div class="margin-auto">
					{!! $houses->links() !!}
				</div>
			</div>
			<div class="card-body">
				@if($houses->count())
				@foreach($houses as $house)
					<div class="card m-t-10">
						<div class="margin-content">
							<div class="col-md-9 float-left">
								<a href="{{ route('admin.rooms.as-owner', $house->id) }}" style="text-decoration-line: none;">
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
								<p><b>Created by</b> : {{ $house->user->user_fname }} {{ $house->user->user_lname }} (last update {{ $house->updated_at->diffForHumans() }})</p>
								</a>
							</div>

							<div class="col-md-3 float-left" align="center">
								{!! Html::linkRoute('admin.rooms.as-owner', 'View room detail', array($house->id), array('class' => 'btn btn-info btn-sm', 'style' => 'width: 150px;')) !!}
							</div>
						</div>
					</div>
				@endforeach
				@else
				<h4>No result</h4>
				@endif
			</div>
			<div class="row" align="center">
				<div class="margin-auto">
					{!! $houses->links() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
