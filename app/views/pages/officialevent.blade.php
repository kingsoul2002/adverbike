@extends('layouts.default')
@section('content')
<div class="container">
	<h3>Official Events</h3>
	@foreach($events as $key => $value)
	<div class="well">
		<div class="media">
			<a class="pull-left" href="{{ $value->crediturl }}">
				<img class="media-object" height='180' width='150' src={{ $value->picurl }}>
			</a>
			<div class="media-body">
				<h4 class="media-heading">{{ $value->title }}</h4>
				<!-- <p class="text-right">By Francisco</p> -->
				<p>Time: {{ $value->date }}</p>
				<p>Place<a href="#"><span class="placeoe" oeid="{{ $value->id }}" data-toggle="modal" data-target="#map">(map<i class="glyphicon glyphicon-map-marker">)</i></span></a>: {{ $value->startplace }}</p>
				<p>More Info: <a href="{{ $value->crediturl }}">Click</a></p>
				<ul class="list-inline list-unstyled pull-right">
					@if($authorized)
						<li>
						{{ Form::open(array('url' => '/join')) }}
							{{ Form::hidden('eventid', $value->id)}}
							{{ Form::hidden('type', 'Official')}}
							{{ Form::button('<span><i class="glyphicon glyphicon-calendar"></i>Join</span>', array('type' => 'submit', 'class' => 'btn btn-submit')) }}
						{{ Form::close() }}
						</li>
					@endif
				</ul>
			</div>
		</div>
	</div>
	@endforeach
	<div class="modal fade" id="map" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Map</h4>
				</div>
				<div class="modal-body">
					<div id="googleMap" align="middle" style="width:500px;height:380px;"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>	
<script>
	var map;
	var markers = [];
	function initialize() {
		var mapProp = {
			center : new google.maps.LatLng(13.872273, 100.523307),
			zoom : 10,
			mapTypeId : google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	$(function(){
		$("#map").on("shown.bs.modal",function(){
			google.maps.event.trigger(map, 'resize');
		});
		$(".placeoe").click(function(){
			for (var i = 0; i < markers.length; i++) {
				markers[i].setMap(null);
			}
			markers = [];
			$.ajax({
				type : "GET",
				url : "/officialevent/position/"+$(this).attr('oeid'),
				success : function(data){
					if(data[0]['x']) {
						for(index in data) {
							var marker = new google.maps.Marker({
								id : index,
								position: new google.maps.LatLng(parseFloat(data[index]['x']), parseFloat(data[index]['y'])),
								map: map,
								animation: google.maps.Animation.DROP
							});
							markers.push(marker);
						}
					}
					if(markers['0'])
						map.setCenter(markers['0'].getPosition());
					else
						map.setCenter(new google.maps.LatLng(13.872273, 100.523307));
					map.setZoom(10);
				}
			});
		});
	});
</script>
@stop