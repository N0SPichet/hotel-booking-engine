<?php

$earningdataPoints = array( 
	array("label"=>"Last Month", "symbol" => "Last Month","y"=> $payment_lastmonth ),
	array("label"=>"Total", "symbol" => "Total","y"=> $total_payment ),
);

$hostdataPoints = array( 
	array("label"=>"Accepted", "symbol" => "Accepted","y"=> ($rentals != 0 ? number_format((float)(($rental_accept/$rentals)*100), 2, '.', '') : 0) ),
	array("label"=>"Rejected", "symbol" => "Rejected","y"=> ($rentals != 0 ? number_format((float)(($rental_reject/$rentals)*100), 2, '.', '') : 0) ),
	array("label"=>"Ignored", "symbol" => "Ignored","y"=> ($rentals != 0 ? number_format((float)(($rental_ignore/$rentals)*100), 2, '.', '') : 0) ),
);

$cusdataPoints = array( 
	array("label"=>"Approved", "symbol" => "Approved","y"=> ($rental_accept != 0 ? number_format((float)(($approved/$rental_accept)*100), 2, '.', '') : 0) ),
	array("label"=>"Waiting", "symbol" => "Waiting","y"=> ($rental_accept != 0 ? number_format((float)(($waiting/$rental_accept)*100), 2, '.', '') : 0) ),
	array("label"=>"Rejected", "symbol" => "Rejected","y"=> ($rental_accept != 0 ? number_format((float)(($reject/$rental_accept)*100), 2, '.', '') : 0) ),
	array("label"=>"Cancel", "symbol" => "Cancel","y"=> ($rental_accept != 0 ? number_format((float)(($cancel/$rental_accept)*100), 2, '.', '') : 0) ),
	array("label"=>"Out of Date", "symbol" => "Out of Date","y"=> ($rental_accept != 0 ? number_format((float)(($ofd/$rental_accept)*100), 2, '.', '') : 0) ), 
);
 
?>

@extends ('main')

@section ('title', 'Summary')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Summary</h1>
		</div>
		<div class="col-md-12">
			<div id="EarningchartContainer" class="margin-top-10" style="height: 370px; width: 100%;"></div>
			<div id="HostchartContainer" class="margin-top-10" style="height: 370px; width: 100%;"></div>
			<div id="CustomerchartContainer" class="margin-top-10" style="height: 370px; width: 100%;"></div>
		</div>
		<!-- <div class="col-md-12">
			<ul class="nav nav-tabs">
	    		<li class=" active" ><a data-toggle="tab" href="#menu1">Earnings</a></li>
	    		<li class=" "><a data-toggle="tab" href="#menu2">Host Rate</a></li>
	    		<li class=" "><a data-toggle="tab" href="#menu3">Customer Rate</a></li>
	  		</ul>
	  		<div class="tab-content">
	    		<div id="menu1" class="tab-pane fade in active">
	    			<div class="card margin-top-10">
	    				<div class="margin-content">
			    			<p>Last 1 Month income {{ $payment_lastmonth }} Thai Baht</p>
			    			<p>Total income {{ $total_payment }} Thai Baht</p>
			    		</div>
			    	</div>
				</div>
				<div id="menu2" class="tab-pane fade">
	    			<div class="card margin-top-10">
	    				<div class="margin-content">
	    					<p>Total request {{ $rentals }} {{ $rentals > 1 ? 'times' : 'time' }}.</p>
			    			@if ($rentals != 0)
			    			<p>Accepted rate {{ number_format((float)(($rental_accept/$rentals)*100), 2, '.', '') }} %</p>
			    			<p>Rejected rate {{ number_format((float)(($rental_reject/$rentals)*100), 2, '.', '') }} %</p>
			    			<p>Ignored rate {{ number_format((float)(($rental_ignore/$rentals)*100), 2, '.', '') }} %</p>
			    			@endif
	    				</div>
	    			</div>
				</div>
				<div id="menu3" class="tab-pane fade">
	    			<div class="card margin-top-10">
	    				<div class="margin-content">
	    					<p>Host accept only {{ $rental_accept }} {{ $rental_accept > 1 ? 'times' : 'time' }}. </p>
	    					@if ($rental_accept != 0)
	    					<p>Approved rate {{ number_format((float)(($approved/$rental_accept)*100), 2, '.', '') }}</p>
	    					<p>Waiting rate {{ number_format((float)(($waiting/$rental_accept)*100), 2, '.', '') }}</p>
	    					<p>Rejected rate {{ number_format((float)(($reject/$rental_accept)*100), 2, '.', '') }}</p>
	    					<p>Cancel rate {{ number_format((float)(($cancel/$rental_accept)*100), 2, '.', '') }}</p>
	    					<p>Out of Date rate {{ number_format((float)(($ofd/$rental_accept)*100), 2, '.', '') }}</p>
	    					@endif
	    				</div>
					</div>
				</div>
	  		</div>			
		</div> -->
	</div>
</div>
@endsection

@section('scripts')
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
	window.onload = function() {

		var chart = new CanvasJS.Chart("EarningchartContainer", {
			animationEnabled: true,
			theme: "light2",
			title:{
				text: "Earning"
			},
			axisY: {
				title: "Income (in Thai Baht)"
			},
			data: [{
				type: "column",
				yValueFormatString: "#,##0.## baht",
				dataPoints: <?php echo json_encode($earningdataPoints, JSON_NUMERIC_CHECK); ?>
			}]
		});
		chart.render();

		var chart = new CanvasJS.Chart("HostchartContainer", {
			theme: "light2",
			animationEnabled: true,
			title: {
				text: "Host Rate"
			},
			data: [{
				type: "doughnut",
				indexLabel: "{symbol} - {y}",
				yValueFormatString: "#,##0.0\"%\"",
				showInLegend: true,
				legendText: "{label} : {y}",
				dataPoints: <?php echo json_encode($hostdataPoints, JSON_NUMERIC_CHECK); ?>
			}]
		});
		chart.render();

		var chart = new CanvasJS.Chart("CustomerchartContainer", {
			theme: "light2",
			animationEnabled: true,
			title: {
				text: "Customer Rate"
			},
			data: [{
				type: "doughnut",
				indexLabel: "{symbol} - {y}",
				yValueFormatString: "#,##0.0\"%\"",
				showInLegend: true,
				legendText: "{label} : {y}",
				dataPoints: <?php echo json_encode($cusdataPoints, JSON_NUMERIC_CHECK); ?>
			}]
		});
		chart.render();
	 
	}
</script>
@endsection