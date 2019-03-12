@extends('dashboard.main')
@section('title', 'Dashboard | Diaries')

@section('content')
<div class="container dashboard-index">
	<div class="col-md-3 float-left m-t-10">
		@include('layouts.side-tab-dashboard')
	</div>
	<div class="col-md-9 float-left m-t-10">
		<div class="card-body">
			<div class="card-title">
				<h4>{{ Auth::user()->user_fname }}'s Diaries</h4>
			</div>
			<div class="card-text">
				<div class="row m-t-10">
					<div class="col-md-12 card">
						<div class="card-title">
							<h4>Diaries <small>({{$diaries->count()}} of {{Auth::user()->diaries->count()}} {{Auth::user()->diaries->count()>1?'diaries':'diary'}})</small></h4>
							<div id="private-diary" class="margin-content">
								<b>Private Status <span>({{$diaries->where('publish', '0')->count()}} of {{Auth::user()->diaries->where('publish', '0')->count()}} {{Auth::user()->diaries->where('publish', '0')->count()>1?'diaries':'diary'}})</span></b>
							</div>
							<div id="public-diary" class="margin-content">
								<b>Public Status <span>({{$diaries->where('publish', '1')->count()}} of {{Auth::user()->diaries->where('publish', '1')->count()}} {{Auth::user()->diaries->where('publish', '1')->count()>1?'diaries':'diary'}})</span></b>
							</div>
							<div id="subscriber-only-diary" class="margin-content">
								<b>Subscriber Only Status <span>({{$diaries->where('publish', '2')->count()}} of {{Auth::user()->diaries->where('publish', '2')->count()}} {{Auth::user()->diaries->where('publish', '2')->count()>1?'diaries':'diary'}})</span></b>
							</div>
							<div id="in-trash-diary" class="margin-content">
								<b>In Trash Status <span>({{$diaries->where('publish', '3')->count()}} of {{Auth::user()->diaries->where('publish', '3')->count()}} {{Auth::user()->diaries->where('publish', '3')->count()>1?'diaries':'diary'}})</span></b>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="margin-content">
						<div class="m-t-10 text-center">
							<a href="{{ route('diaries.mydiaries', Auth::user()->id) }}" class="btn btn-info">All Diaries</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		var diaries = {!! $diaries !!};
		$.each(diaries, function(index, data) {
			var publishflag;
			var diaryUrl = '{{ route("diaries.single", ":id") }}';
			diaryUrl = diaryUrl.replace(':id', data.id);
			if (data.days == '0') {
				var diaryUrl = '{{ route("diaries.tripdiary", [":rentalid", ":userid"]) }}';
				diaryUrl = diaryUrl.replace(':rentalid', data.rental_id);
				diaryUrl = diaryUrl.replace(':userid', data.user_id);
			}

			var diaryUrlDelete = '{{ route('diaries.destroy', ':id') }}';
			diaryUrlDelete = diaryUrlDelete.replace(':id', data.id);
			if (data.days == '0') {
				var diaryUrlDelete = '{{ route('diaries.tripdiary.destroy', ':id') }}';
				diaryUrlDelete = diaryUrlDelete.replace(':id', data.rental_id);
			}
			var del_form = '<form method="POST" action="'+diaryUrlDelete+'" accept-charset="UTF-8" style="display: inline;"><input name="_method" type="hidden" value="DELETE"><input name="_token" type="hidden" value="'+$('meta[name="csrf-token"]').attr('content')+'"><button type="submit" class="btn btn-danger" title="delete the diary"><i class="fas fa-trash"></i> Delete</button></form>';

			var diaryUrlEdit = '{{ route("diaries.edit", ":id") }}';
			diaryUrlEdit = diaryUrlEdit.replace(':id', data.id);
			if (data.days == '0') {
				var diaryUrlEdit = '{{ route("diaries.tripdiary", [":rentalid", ":userid"]) }}';
				diaryUrlEdit = diaryUrlEdit.replace(':rentalid', data.rental_id);
				diaryUrlEdit = diaryUrlEdit.replace(':userid', data.user_id);
			}
			var action_edit = '<a target="_blank" href="'+diaryUrlEdit+'" class="btn btn-sm btn-warning" title="edit the diary">edit</a>';

			var diaryUrlTempDelete = '{{ route('diaries.temp.delete', ':id') }}';
			diaryUrlTempDelete = diaryUrlTempDelete.replace(':id', data.id);
			var diaryUrlRestore = '{{ route('diaries.restore', ':id') }}';
			diaryUrlRestore = diaryUrlRestore.replace(':id', data.id);
			var action_del_restore = '<a href="'+diaryUrlTempDelete+'" class="btn btn-sm btn-danger" title="move the diary to trash">Move to trash</a>';
			if (data.publish == 0) {
				publishflag = '<span class="text-danger"><i class="fas fa-eye-slash"></i> private</span>';
				$('#private-diary').append('<div class="col-md-12 m-t-10"><a target="_blank" href="'+diaryUrl+'" class="btn btn-sm btn-info">open</a> '+action_edit+' '+action_del_restore+' <p><b>'+publishflag+'</b> - '+data.title+'</p></div>');
			}
			else if (data.publish == 1) {
				publishflag = '<span class="text-success"><i class="fas fa-eye"></i> publish</span>';
				$('#public-diary').append('<div class="col-md-12 m-t-10"><a target="_blank" href="'+diaryUrl+'" class="btn btn-sm btn-info">open</a> '+action_edit+' '+action_del_restore+' <p><b>'+publishflag+'</b> - '+data.title+'</p></div>');
			}
			else if (data.publish == 2) {
				publishflag = '<span class="text-warning"><i class="fas fa-eye"></i> subscriber only</span>';
				$('#subscriber-only-diary').append('<div class="col-md-12 m-t-10"><a target="_blank" href="'+diaryUrl+'" class="btn btn-sm btn-info">open</a> '+action_edit+' '+action_del_restore+' <p><b>'+publishflag+'</b> - '+data.title+'</p></div>');
			}
			else if (data.publish == 3) {
				publishflag = '<span class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i> in trash</span>';
				action_edit = '<a href="'+diaryUrlRestore+'" class="btn btn-sm btn-warning" title="after restore the diary status will change to '+"'"+'private'+"'"+'">Restore</a>'
				$('#in-trash-diary').append('<div class="col-md-12 m-t-10"><a target="_blank" href="'+diaryUrl+'" class="btn btn-sm btn-info">open</a> '+action_edit+' '+del_form+' <p><b>'+publishflag+'</b> - '+data.title+'</p></div>');
			}
		});
	});
</script>
@endsection
