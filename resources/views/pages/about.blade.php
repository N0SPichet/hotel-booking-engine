@extends('main')

@section('title','ABOUT US')

@section('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class=""><h1 class="title-page">About Us</h1></div>

			<div class="panel-body">
				<p>เว็บไซต์นี้ก่อตั้งขึ้นเพื่อเป็นกลุ่มของชุมชนที่เชื่อถือได้สำหรับลงประกาศ ค้นหา และจองที่พักที่ ที่รองรับได้ทั้งบนโทรศัพท์มือถือหรือคอมพิวเตอร์ ไม่ว่าจะเป็นอพาร์ทเมนท์หนึ่งคืน ห้องพักริมทะเลหนึ่งสัปดาห์ เว็บไซต์เราเป็นตัวเชื่อมโยงคนเหล่านี้เข้าด้วย ผู้ที่มีห้องในบ้านว่างก็สามารถเปิดเป็นห้องให้นักเดินทางมาเช่าได้ ด้วยราคาที่เหมาะสม เราหวังว่าเว็บไซต์เราจะเติบโตขึ้นเรื่อยๆ เราจะช่วยให้ห้องพักของคุณเป็นที่รู้จัก และสำหรับผู้มาพักเราจะเป็นส่วนหนึ่งที่จะช่วยคุณหาห้องพักที่คุณต้องการให้เอง</p>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
	{!! Html::script('js/select2.min.js') !!}
	<script type="text/javascript">
		$('.select2-multi').select2();

		$(document).ready(function() {

			/* This is basic - uses default settings */
			
			$("a#single_image").fancybox();
			
			/* Using custom settings */
			
			$("a#inline").fancybox({
				'hideOnContentClick': true
			});

			/* Apply fancybox to multiple items */
			
			$("a.group").fancybox({
				'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200, 
				'overlayShow'	:	false
			});
			
		});
	</script>
@endsection