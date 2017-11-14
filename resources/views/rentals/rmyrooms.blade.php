@extends ('main')

@section ('title', 'Rentals')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
@endsection

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Rentals</h1>
		</div>

		<div class="col-md-3 col-md-offset-0">
			<h2>Check in Code</h2>
			<p><small>put checkin code here if it true, you will get granted status</small></p>
			@if ($errors->any())
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif
			{{ Form::open(array('route' => 'checkin.code', 'data-parsley-validate' => '')) }}
				{{ Form::label('rent_id', 'Rent id') }}
				{{ Form::text('rent_id', null, array('class' => 'form-control', 'required' => '')) }}

				{{ Form::label('checkin_code', 'Code here') }}
				{{ Form::text('checkin_code', null, array('class' => 'form-control', 'required' => '')) }}
				<div class="text-center">
					{{ Form::submit('Check in', array('class' => 'btn btn-success btn-md btn-h1-spacing')) }}
				</div>
			{{ Form::close() }}
		</div>

		<div class="col-md-5 col-md-offset-0">
			<h2>New rental</h2>
			<p><small>rental at new state</small></p>
			<label>Rooms</label>
			@foreach ($houses as $house)
				<button class="btn btn-info btn-md btn-block form-spacing-top-8" type="button" data-toggle="collapse" data-target="#{{ $house->id }}" aria-expanded="true">
					{{ $house->house_title }}
				</button>
				<div class="collapse" id="{{ $house->id }}">
					<div class="card card-block">
					@foreach ($rentals as $rental)
						@if ($rental->houses_id == $house->id)
							@if ($rental->payments->payment_status == NULL  && $rental->host_decision != 'ACCEPT')
								<a href="{{ route('rentals.show', $rental->id) }}">
									<p>Rent #ID : {{ $rental->id }}</p>
									<p>Rented by :{{ $rental->users->user_fname }} {{ $rental->users->user_lname }}</p>
								</a>
							@endif
						@endif
					@endforeach
					</div>
				</div>
			@endforeach
		</div>

		<div class="col-md-4 col-md-offset-0">
			<h2>History</h2>
			<p><small>approved, cancel and rejected rental</small></p>
			{!! Html::linkRoute('rentals.rhistories', 'View History', array(), ['class' => 'btn btn-info btn-md btn-block', 'target' => '_blank']) !!}
		</div>

	</div>
</div>
@endsection