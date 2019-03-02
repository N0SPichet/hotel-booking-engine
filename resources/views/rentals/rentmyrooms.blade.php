@extends ('manages.main')
@section ('title', 'Rentals')
@section('stylesheets')
{{ Html::style('css/parsley.css') }}
@endsection
@section ('content')
<div class="container rentals">
	<div class="row m-t-10">
		<div class="col-md-12">
			<h1>Rentals</h1>
			@if (Auth::user()->verification->passport != null)
			<p>host passport : <b class="text-danger">{{ substr(Auth::user()->verification->passport, 9, 3) }}{{ substr(Auth::user()->verification->passport, 15, 3) }}{{ substr(Auth::user()->verification->passport, 12, 3) }}</b> keep it's secret</p>
			@endif
		</div>

		<div class="col-md-3">
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
			{{ Form::open(array('route' => 'rentals.checkin.code', 'data-parsley-validate' => '')) }}
				{{ Form::label('rent_id', 'Rent id') }}
				{{ Form::text('rent_id', null, array('class' => 'form-control', 'required' => '')) }}

				{{ Form::label('checkin_code', 'Code here') }}
				{{ Form::text('checkin_code', null, array('class' => 'form-control', 'required' => '')) }}
				<div class="text-center">
					{{ Form::submit('Check in', array('class' => 'btn btn-success btn-md btn-h1-spacing')) }}
				</div>
			{{ Form::close() }}
		</div>

		<div class="col-md-9">
			<ul class="nav nav-tabs rental_info">
	    		<li class="active"><a data-toggle="tab" href="#menu1">New Rental <span class="badge badge-danger">{{ $rental_new }}</span></a></li>
	    		<li><a data-toggle="tab" href="#menu2">Waiting for Payment <span class="badge badge-danger">{{ $payment_waiting_badge }}</span></a></li>
	    		<li><a data-toggle="tab" href="#menu3">Arrive Confirmed <span class="badge badge-danger">{{ $payment_approved_badge }}</span></a></li>
	    		<li><a data-toggle="tab" href="#menu4">History</a></li>
	  		</ul>

	  		<div class="tab-content">
	    		<div id="menu1" class="tab-pane fade show active in">
	    			@if($houses->count())
	    			<div class="col-md-3 float-left">
		    			<ul class="nav myroom-lists m-t-10">
		      			@foreach ($houses as $key => $house)
							<li><a data-toggle="pill" href="#room{{ $house->id }}" style="width: 140px;">{{ $house->house_title }} <span class="badge badge-danger float-right m-r-10">{{ $rent_count[$key] }}</span></a></li>
						@endforeach
						</ul>
					</div>
					<div class="col-md-9 float-left">
						<div class="tab-content m-t-10">
							@foreach ($houses as $house)
							<div id="room{{ $house->id }}" class="tab-pane fade">
								@foreach ($rentals as $rental)
		      					@if ($rental->house_id == $house->id)
									@if ($rental->payment->payment_status == NULL  && $rental->host_decision != 'ACCEPT' && $rental->host_decision != 'REJECT')
									<div class="card">
										<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;" class="btn btn-default btn-block text-left">
										<p>Rented by : {{ $rental->user->user_fname }} {{ $rental->user->user_lname }}</p>
										<p>Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }}</p>
										</a>
									</div>
									@endif
								@endif
		    					@endforeach
		    				</div>
	    					@endforeach
	    				</div>
					</div>
					@else
					<div class="text-center m-t-10">
						<p>No info</p>
					</div>
					@endif
	    		</div>
	    		<div id="menu2" class="tab-pane fade">
	    			@if($rentals_waiting->count())
	    			<div class="tab-content m-t-10">
	    				@foreach ($rentals_waiting as $rental)
	    				<div class="card">
		      				<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;" class="btn btn-default btn-block text-left">
								<p>Rented by : {{ $rental->user->user_fname }} {{ $rental->user->user_lname }}</p>
								<p>Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }}</p>
							</a>
						</div>
		      			@endforeach
	    			</div>
	    			@else
	    			<div class="text-center m-t-10">
	    				<p>No info</p>
	    			</div>
	    			@endif
	    		</div>
	    		<div id="menu3" class="tab-pane fade">
	    			@if($rentals_approved->count())
	    			<div class="tab-content m-t-10">
	    				@foreach ($rentals_approved as $rental)
	    				<div class="card">
			      			<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;" class="btn btn-default btn-block text-left">
								<p>Rented by : {{ $rental->user->user_fname }} {{ $rental->user->user_lname }}
									@if ($rental->checkin_status == '1') <span class="text-success"><i class="far fa-check-circle"></i> Checkin</span> @endif
								</p>
								<p>Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }}</p>
							</a>
						</div>
		      			@endforeach
	    			</div>
	    			@else
	    			<div class="text-center m-t-10">
	    				<p>No info</p>
	    			</div>
	    			@endif
	    		</div>
	    		<div id="menu4" class="tab-pane fade">
	    			<div class="card">
	    				<div class="margin-content">
	    					{!! Html::linkRoute('rentals.renthistories', 'View History', array(Auth::user()->id), ['class' => '']) !!}
	    				</div>
	    			</div>
	    		</div>
	  		</div>			
		</div>
	</div>
</div>
@endsection
@section('scripts')
{!! Html::script('js/parsley.min.js') !!}
@endsection
