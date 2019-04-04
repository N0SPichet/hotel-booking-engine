@extends ('dashboard.main')
@section ('title', 'Request Withdraw')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="panel-heading text-center "><h1 class="title-page">Request Withdraw</h1></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="row" align="center">
				<div class="margin-auto">
					{!! $payments->links() !!}
				</div>
			</div>
			<div class="">
				<a href="{{ route('dashboard.payments.create') }}" class="btn btn-danger">Create Request</a>
			</div>
			<div class="card m-t-10">
				@if ($payments->count())
				@foreach ($payments as $key => $payment)
				<div class="margin-content">
					<a href="{{ route('dashboard.payments.show', $payment->id) }}">
					<div class="col-md-2 float-left">
						<p>#{{ $payment->id }}</p>
					</div>
					<div class="col-md-8 float-left">
						<p>{{ $payment->payment_amount }} Thai baht (withdraw - <span class="{!! $payment->payment_status=='Approved'? 'text-success':'' !!}">{!! $payment->payment_status !!}</span>)</p>
					</div>
					<div class="col-md-2 float-left">
						<p>Show</p>
					</div>
					</a>
				</div>
				@endforeach
				@else
				<div class="margin-content">
				<p>No info</p>
				</div>
				@endif
			</div>
			<div class="row" align="center">
				<div class="margin-auto">
					{!! $payments->links() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
