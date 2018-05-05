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
		<div class="col">
			@foreach($diaries as $diary)
			@if ($diary->users_id == Auth::user()->id)
			<div class="panel panel-default col">
				<div class="panel-heading">
					@if ($diary->days != '0')
					<a href="{{ route('diary.single', $diary->id) }}" style="text-decoration-line: none;">
					@elseif ($diary->days == '0')
					<a href="{{ route('tripdiary', $diary->rentals_id) }}" style="text-decoration-line: none;">
					@endif
					@if ($diary->publish == '2')
					<span class="text-success margin-top-20"><i class="fas fa-eye"></i> Published</span>
					@elseif ($diary->publish == '1')
					<span class="text-primary margin-top-20"><i class="fas fa-eye"></i> Follower</span>
					@elseif ($diary->publish == '0')
					<span class="text-danger margin-top-20"><i class="fas fa-eye-slash"></i> Private</span>
					@endif
					<span style="font-size: 20px;"><b> {{ $diary->title }} </b></span>
					@if ($diary->days == '0') <span>({{ $diary->rentals->houses->house_title }} - {{ date('jS F, Y', strtotime($diary->rentals->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($diary->rentals->rental_dateout)) }})</span>
					@endif
					</a>
					@if ($diary->days != '0')
					<a href="{{ route('diary.single', $diary->id) }}" class="btn btn-primary btn-sm pull-right">Read More</a>
					<a href="{{ route('diaries.edit', $diary->id) }}" class="btn btn-outline-warning btn-sm pull-right" style="margin-right: 20px;"><i class="far fa-edit"></i> Edit</a>
					@elseif ($diary->days == '0')
					<a href="{{ route('tripdiary', $diary->rentals_id) }}" class="btn btn-primary btn-sm pull-right">Read More</a>
					@endif
				</div>
				<div class="panel-body">
					<p style="color: #7e7e7e; font-size: 14px; letter-spacing: .04em;">Date modified {{ date('jS F, Y - g:iA', strtotime($diary->updated_at)) }}</p>
					<div class="text-over-flow-ellipsis"> {!! $diary->message !!} </div>
				</div>
			</div>
			<!-- <div class="card">
				<div class="row">
					<div class="col-md-7">
						<b> {{ $diary->title }} </b>
						<div class="text-over-flow-ellipsis"> {!! $diary->message !!} </div> -->
						<!-- <td> {{ substr($diary->message, 0, 60) }} {{ strlen($diary->message) > 60 ? "..." : "" }} </td> -->
					<!-- </div>
					<div class="col-md-3 col-md-offset-0">
						<p><b> Category </b> : {{ $diary->categories->category_name }} </p>
						<p><b> Created by </b> : {{ $diary->users->user_fname }} </p>
						<p><b> Last Update </b> : {{ date('M j, Y', strtotime($diary->updated_at)) }} </p>
					</div>
					<div class="col-md-2">
						<div class="col-md-12">
							@if ($diary->days != '0')
							<a href="{{ route('diary.single', $diary->id) }}" class="btn btn-primary btn-sm btn-block">Read More</a>
							<a href="{{ route('diaries.edit', $diary->id) }}" class="btn btn-outline-warning btn-sm btn-block">Edit</a>
							@elseif ($diary->days == '0')
							<a href="{{ route('tripdiary', $diary->rentals_id) }}" class="btn btn-primary btn-sm btn-block">Read More</a>
							@endif
						</div>
					</div>
				</div>
			</div> -->
			@endif
			@endforeach
			<div class="text-center">
				{!! $diaries->links() !!}
			</div>
		</div>
	</div>

</div>
@endsection