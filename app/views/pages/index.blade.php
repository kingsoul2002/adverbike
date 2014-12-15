@extends('layouts.default')
@section('content')
<div class="container">
	<h3>Official Events</h3>
	@foreach($oevents as $key => $value)
	<div class="well">
		<div class="media">
			<a class="pull-left" href="{{ $value->crediturl }}">
				<img class="media-object" height='180' width='150' src={{ $value->picurl }}>
			</a>
			<div class="media-body">
				<h4 class="media-heading">{{ $value->title }}</h4>
				<p>Time: {{ $value->date }}</p>
				<p>Place<a href="#"><span class="placeoe" oeid="{{ $value->id }}" data-toggle="modal" data-target="#map">(View Map<i class="glyphicon glyphicon-map-marker">)</i></span></a>: {{ $value->startplace }}</p>
				<p>More Info: <a href="{{ $value->crediturl }}">Click</a></p>
				<ul class="list-inline list-unstyled pull-right">
					@if($authorized)
						<li>
						{{ Form::open(array('url' => '/join')) }}
							{{ Form::hidden('eventid', $value->id)}}
							{{ Form::hidden('type', 'Official')}}
							{{ Form::button('<span><i class="glyphicon glyphicon-calendar"></i>Join</span>', array('type' => 'submit', 'class' => 'btn btn-default')) }}
						{{ Form::close() }}
						</li>
					@endif
				</ul>
			</div>
		</div>
	</div>
	@endforeach
	@if($authorized)
		<h3>Member Events <a href="/creatememberevent" class="btn btn-default">Create Event</a></h3>
		@foreach($mevents as $key => $value)
			<div class="well col-md-4">
				<h4 align="middle">{{ $value->name }}</h4>
				<p>Created By: {{ $value->fullname }}</p>
				<p>Appointment Time: {{ $value->appointment }}</p>
				<p>Start At: {{ $value->startplace }}</p>
				<p>End At: {{ $value->endplace }}</p>
				{{ Form::open(array('url' => '/join', 'class' => 'form form-inline')) }}
					<a class="btn btn-default placeme" meid="{{ $value->mevent_id }}" href="#" role="button" data-toggle="modal" data-target="#map">View Map »</a>
					<a class="btn btn-default" href="#" role="button" data-toggle="modal" data-target="#membereventdetail{{ $value->mevent_id }}">View Detail »</a>
					{{ Form::hidden('eventid', $value->mevent_id)}}
					{{ Form::hidden('type', 'Member')}}
					{{ Form::button('<span><i class="glyphicon glyphicon-calendar"></i>Join</span>', array('type' => 'submit', 'class' => 'btn btn-default')) }}
				{{ Form::close() }}
			</div>
			<div class="modal fade" id="membereventdetail{{ $value->mevent_id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Detail Event {{ $value->name }}</h4>
						</div>
						<div class="modal-body">
							{{ $value->description }}
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	@endif
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
	var poly;
	var path = [];
	var markers = [];
	function initialize() {
		var mapProp = {
			center : new google.maps.LatLng(13.872273, 100.523307),
			zoom : 10,
			mapTypeId : google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

		var polyOptions = {
			strokeColor: '#000000',
			strokeOpacity: 1.0,
			strokeWeight: 3
		};
		poly = new google.maps.Polyline(polyOptions);
		poly.setMap(map);
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
			poly.getPath().clear();
			path = [];
			$.ajax({
				type : "GET",
				url : "/officialevent/position/"+$(this).attr('oeid'),
				success : function(data){
					if(data[0][0]['x']) {
						for(index in data) {
							var marker = new google.maps.Marker({
								id : index,
								position: new google.maps.LatLng(parseFloat(data[index][0]['x']), parseFloat(data[index][0]['y'])),
								map: map,
								animation: google.maps.Animation.DROP
							});
							markers.push(marker);
						}
					}
					if(markers[0])
						map.setCenter(markers[0].getPosition());
					else
						map.setCenter(new google.maps.LatLng(13.872273, 100.523307));
					map.setZoom(10);
				}
			});
		});
		$(".placeme").click(function(){
			for (var i = 0; i < markers.length; i++) {
				markers[i].setMap(null);
			}
			markers = [];
			poly.getPath().clear();
			path = poly.getPath();
			$.ajax({
				type : "GET",
				url : "/memberevent/position/"+$(this).attr('meid'),
				success : function(data){
					if(data[0][0]['x']) {
						for(index in data) {
							path.push(new google.maps.LatLng(parseFloat(data[index][0]['x']), parseFloat(data[index][0]['y'])));
							if (index == 0) {
								var marker = new google.maps.Marker({
									id : 0,
									position: new google.maps.LatLng(parseFloat(data[index][0]['x']), parseFloat(data[index][0]['y'])),
									map: map,
									animation: google.maps.Animation.DROP
								});
								markers.push(marker); 
							}
							if (index == data.length - 1) {
								var marker = new google.maps.Marker({
									id : 1,
									position: new google.maps.LatLng(parseFloat(data[index][0]['x']), parseFloat(data[index][0]['y'])),
									map: map,
									icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
									animation: google.maps.Animation.DROP
								});
								markers.push(marker);
							}
						}
					}
					if(markers[0])
						map.setCenter(markers[0].getPosition());
					else
						map.setCenter(new google.maps.LatLng(13.872273, 100.523307));

					map.setZoom(10);
				}
			});
		});
	});
</script>
@stop