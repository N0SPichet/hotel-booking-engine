@extends ('main')

@section ('title', 'Rentals')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
@endsection

@section ('content')
<div class="container rentals">
	<div class="row m-t-10">
		<div class="col-md-12">
			<h1>Rentals</h1>
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
	    		<li><a data-toggle="tab" href="#menu1">New Rental <span class="badge badge-danger">{{ $rental_new }}</span></a></li>
	    		<li><a data-toggle="tab" href="#menu2">Waiting for Payment <span class="badge badge-danger">{{ $payment_waiting_badge }}</span></a></li>
	    		<li><a data-toggle="tab" href="#menu3">Arrive Confirmed <span class="badge badge-danger">{{ $payment_approved_badge }}</span></a></li>
	    		<li><a data-toggle="tab" href="#menu4">History</a></li>
	  		</ul>

	  		<div class="tab-content">
	    		<div id="menu1" class="tab-pane fade show in active">
	    			<div class="col-md-3 float-left">
		    			<ul class="nav nav-pills m-t-10">
		      			@foreach ($houses as $house)
							<li><a data-toggle="pill" href="#room{{ $house->id }}" style="width: 140px;">{{ $house->house_title }}</a></li>
						@endforeach
						</ul>
					</div>
					<div class="col-md-9 float-left">
						<div class="tab-content m-t-10">
							@foreach ($houses as $house)
							<div id="room{{ $house->id }}" class="tab-pane fade">
								@foreach ($rentals as $rental)
		      					@if ($rental->houses_id == $house->id)
									@if ($rental->payment->payment_status == NULL  && $rental->host_decision != 'ACCEPT' && $rental->host_decision != 'REJECT')
										<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;" class="btn btn-default btn-block text-left">
											<p>Rented by :{{ $rental->user->user_fname }} {{ $rental->user->user_lname }}</p>
											<p>Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }}</p>
										</a>
									@endif
								@endif
		    					@endforeach
		    				</div>
	    					@endforeach
	    				</div>
					</div>
	    		</div>
	    		<div id="menu2" class="tab-pane fade">
	    			<div class="tab-content m-t-10">
	    				@foreach ($rentals_waiting as $rental)
		      			<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;" class="btn btn-default btn-block text-left">
							<p>Rented by :{{ $rental->user->user_fname }} {{ $rental->user->user_lname }}</p>
							<p>Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }}</p>
						</a>
		      			@endforeach
	    			</div>
	    		</div>
	    		<div id="menu3" class="tab-pane fade">
	    			<div class="tab-content m-t-10">
	    				@foreach ($rentals_approved as $rental)
		      			<a href="{{ route('rentals.show', $rental->id) }}" style="text-decoration-line: none;" class="btn btn-default btn-block text-left">
							<p>Rented by : {{ $rental->user->user_fname }} {{ $rental->user->user_lname }}
								@if ($rental->checkin_status == '1') <span class="text-success"><i class="far fa-check-circle"></i> Checkin</span> @endif
							</p>
							<p>Stay Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }}</p>
						</a>
		      			@endforeach
	    			</div>
	    		</div>
	    		<div id="menu4" class="tab-pane fade">
	    			<div class="card">
	    				<div class="margin-content">
	    					{!! Html::linkRoute('rentals.renthistories', 'View History', array(Auth::user()->id), ['class' => 'btn btn-info btn-md', 'target' => '_blank']) !!}
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
