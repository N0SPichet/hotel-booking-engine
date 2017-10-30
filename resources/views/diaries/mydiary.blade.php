@extends ('main')

@section ('title', 'My Diary')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-10">
			<h1>My Diaries</h1>
		</div>

		<div class="col-md-2">
			<a href=" {{ route('diaries.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Create Diary</a>
		</div>

		<div class="col-md-12">
			<hr>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			@foreach($diaries as $diary)
				<div class="row">
					
					<div class="col-md-7">
						<p><b> {{ $diary->title }} </b></p>
						<div class="text-over-flow-ellipsis"> {{ $diary->message }} </div>
						<!-- <td> {{ substr($diary->message, 0, 60) }} {{ strlen($diary->message) > 60 ? "..." : "" }} </td> -->
					</div>

					<div class="col-md-3 col-md-offset-0">
						<p><b> Category </b> : {{ $diary->categories->category_name }} </p>
						<p><b> Created by </b> : {{ $diary->users->user_fname }} </p>
						<p><b> Last Update </b> : {{ date('M j, Y', strtotime($diary->updated_at)) }} </p>
					</div>

					<div class="col-md-2">
						<div class="col-md-12">
							<a href="{{ route('diary.single', $diary->id) }}" class="btn btn-default btn-sm btn-block">Read More</a>
							<a href="{{ route('diaries.edit', $diary->id) }}" class="btn btn-default btn-sm btn-block">Edit</a>
						</div>
					</div>

				</div>
				<hr>
			@endforeach

			<div class="text-center">
				<!-- generate link for siary item -->
				{!! $diaries->links() !!}
			</div>
		</div>
	</div>

</div>
@endsection