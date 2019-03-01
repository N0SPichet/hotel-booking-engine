@extends ('main')
@section ('title', 'Diaries')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-md-12">
			<h1 class="title-page">Diaries</h1>	
		</div>
	</div>
	<div class="row" align="center">
		<div class="margin-auto">
			{!! $diaries->links() !!}
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			@foreach($diaries as $diary)
			<div class="col-md-6 col-sm-6 float-left">
				@if ($diary->days == '0' || $diary->days == NULL)
				<div class="card" style="margin-top: 20px; width: 100%; height: 250px;">
					<div class="col-md-12">
						<p class="thumb-article__date">{{ $diary->user->user_fname }} {{ date('jS F, Y - g:iA', strtotime($diary->created_at)) }}</p>
						<h3 class="thumb-article__title"><a href="{{ route('diaries.show', $diary->id) }}" style="text-decoration: none;">{{ $diary->title }}</a></h3>
						<div class="thumb-article__excerpt text-over-flow-ellipsis">
							<p>{{ substr(strip_tags($diary->message), 0, 200) }} {{ strlen(strip_tags($diary->message)) > 200 ? "..." : "" }}</p>
						</div>
					</div>
				</div>
				@endif
			</div>
			@endforeach
		</div>
	</div>
	<div class="row" align="center">
		<div class="margin-auto">
			{!! $diaries->links() !!}
		</div>
	</div>
</div>
@endsection