@extends ('main')

@section ('title', 'Introduction to Hosting Apartment')

@section ('content')

	<div class="container">
		<div class="row">
			<h2 class="title-page">Introduction to Hosting Apartment</h2>

			<div class="col-md-12">
				<div class="col-md-10 float-left">
					<p>สวัสดี {{ Auth::user()->user_fname }} </p>
				</div>
				<div class="col-md-2 float-left">
					<a href="{{ route('apartments.create') }}" class="btn btn-danger margin-top-10 poll-right">Create Apartment</a>
				</div>
				<p>ในส่วนนี้เหมาะกับผู้ใช้เช่าขนาดใหญ่ ที่มีห้องประเภทหอพัก อพาร์ทเม้น</p>
				<p>ประเภทของห้องพักที่แนะนำ</p>
				<ul>
					<li>Apartment</li>
					<li>Hotel</li>
				</ul>
				<p>หากท่านมีห้องพักตามที่แนะนำข้างต้น สามารถกดปุ่ม Next เพื่อทำการสร้างห้องพักได้เลย แต่ถ้าหากท่านไม่มีห้องพักตามที่แนะนำ ท่านสามารถกดได้ที่ลิ้งด้านล่างนี้ ระบบจะพาท่านไปยังหน้าสร้างห้องพักที่เหมาะสมกับท่าน</p><br>
				<b><a href="{{ route('hosts.introroom') }}" class="btn btn-secondary btn-sm">ให้เช่าห้องพักแบบบ้านเดี่ยวหรือห้องเดี่ยว</a></b>
				<br><br>
				<p>เราหวังว่าท่านจะมีความสุข และสามารถต้อนรับผู้เช่าบ้านที่กำลังจะมาถึงได้เป็นอย่างดี เพื่อจะได้เพิ่มยอดผู้เข้าพักในห้องพักท่านของท่านได้</p>
			</div>
			<div class="col-md-12">
				<h4>Your listing</h4>
				<a href="{{ route('apartments.index-myapartment', Auth::user()->id) }}" class="btn btn-lg btn-info margin-top-10" style="width: 200px;">Apartment</a>
			</div>
		</div>
	</div>

@endsection
