@extends ('main')

@section ('title', 'Introduction to Hosting Room')

@section ('content')

	<div class="container">
		<div class="row">
			<h2 class="title-page">Introduction to Hosting Room</h2>

			<div class="col-md-12 col-sm-12">
				<div class="col-md-10 col-sm-10">
					<p>สวัสดี {{ Auth::user()->user_fname }}</p>
				</div>
				<div class="col-md-2 col-sm-2">
					<a href="{{ route('rooms.create') }}" class="btn btn-danger margin-top-10 pull-right">Create Room</a>
				</div>
				<p>ในส่วนนี้เหมาะกับผู้ให้เช่าขนาดเล็ก อาจจะเป็นห้องพักในคอนโด หรือห้องว่างในบ้านตัวเอง</p>
				<p>ประเภทของห้องพักที่แนะนำได้แก่</p>
				<ul>
					<li>Condominium</li>
					<li>Guesthouse</li>
					<li>House</li>
					<li>In-law</li>
					<li>Townhouse</li>
					<li>Vacation home</li>
				</ul>
				<p>หากท่านมีห้องพักตามที่แนะนำข้างต้น สามารถกดปุ่ม Next เพื่อทำการสร้างห้องพักได้เลย แต่ถ้าหากท่านไม่มีห้องพักตามที่แนะนำ (เป็นแบบหอพัก) ท่านสามารถกดได้ที่ลิ้งด้านล่างนี้ ระบบจะพาท่านไปยังหน้าสร้างห้องพักที่เหมาะสมกับท่าน</p><br>
				<b><a href="{{ route('hosts.introapartment') }}" class="btn btn-secondary btn-sm">ให้เช่าห้องพักแบบ Apartment</a></b>
				<br><br>
				<p>เราหวังว่าท่านจะมีความสุข และสามารถต้อนรับผู้เช่าบ้านที่กำลังจะมาถึงได้เป็นอย่างดี เพื่อจะได้เพิ่มยอดผู้เข้าพักในห้องพักท่านของท่านได้</p>
			</div>
			<div class="col-md-12 col-sm-12">
				<h4>Your listing</h4>
				<a href="{{ route('index-myroom', Auth::user()->id) }}" class="btn btn-lg btn-info margin-top-10" style="width: 100px;">Room</a>
			</div>
		</div>
	</div>

@endsection
