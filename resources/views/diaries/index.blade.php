@extends ('main')

@section ('title', 'Diaries')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Diaries</h1>
			<hr>	
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			@foreach($diaries as $diary)
				<div class="row">
					
					<div class="col-md-9">
						<p><b> {{ $diary->title }} </b></p>
						<div class="text-over-flow-ellipsis"> {{ $diary->message }} </div>
					</div>

					<div class="col-md-3 col-md-offset-0">
						<p><b> Category </b> : {{ $diary->categories->category_name }} </p>
						<p><b> Created by </b> : {{ $diary->users->user_fname }} </p>
					</div>

					<div class="col-md-12">
						<p><a href="{{ route('diaries.show', $diary->id) }}" class="btn btn-primary btn-md">Read More</a></p>
						<hr>
					</div>
				</div>
			@endforeach

			<div class="text-center">
				{!! $diaries->links() !!}
			</div>
		</div>
	</div>

</div>
@endsection