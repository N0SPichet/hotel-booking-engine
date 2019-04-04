@extends ('dashboard.main')
@section ('title', 'Create | Request Withdraw')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('dashboard.payments.index') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-12">
			<div class="card">
				<div class="margin-content">
					<h4>Development..</h4>
					{{-- <form action="">
						<input type="text" name="">
					</form> --}}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
