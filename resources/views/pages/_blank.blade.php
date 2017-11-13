@extends('main')

@section('title','Blank Page')

@section('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading"><h4>Blank Page</h4></div>

			<div class="panel-body">
				<p>Genarated Code for Check in : {{ $randomString }}</p>
				<p>ส่งรหัสนี้ให้เจ้าของบ้านเพื่อเป็นการยืนยันว่าเราได้เช่าบ้านเขาจริงๆ หากตรงกันจะแสดงข้อความ 'Granted' หากไม่ตรงกันจะแสดงข้อความ 'Denial'</p>
				<p>ผู้ให้เช่าห้องพักจะทราบรหัสนี้ ผู้เช่าห้องพักจะทราบรหัสนี้</p>
				<p>การได้รหัสเข้าพัก จะได้หลังจากการเช่านั้นเป็นสถานะ 'Approved' เท่านั้น ในสถานะ 'Waiting' ผู้เช่าจะเห็นแค่ข้อมูลห้องพักที่เช่า รายละเอียดการจ่ายเงิน แต่จะไม่เห็นรหัส</p>
				<p>สถานะการเช่าจะเป็น 'Approved' ก็ต่อเมื่อรายละเอียดการโอนเงินเป็นจริง และตรงกับที่ระบบได้รับ เนื่องจากในปัจจุบันยังไม่มีระบบอัติโนมัติ การอนุมัติการจองจะเกิดขึ้นโดย Admin ใช้เวลารอระหว่าง 1-2 ชั่วโมง</p>
			</div>
		</div>
		
	</div>
</div>
@endsection