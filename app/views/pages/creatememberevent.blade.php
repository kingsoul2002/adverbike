@extends('layouts.default')
@section('content')
<div class="container" >
	<h3>Create Event</h3>
	<form role="form" action="/creatememberevent" method="post" >
		<div class="col-md-12">
			<div class="form-group form-inline has-feedback">
				<label class="col-md-3" for="eventname">Event Name*</label>
				@if (Session::has('error') && array_key_exists('eventname', Session::get('error')) && !is_null(Session::get('error')['eventname']) && array_key_exists('0', Session::get('error')['eventname']) && !is_null(Session::get('error')['eventname']['0']))
					<div class="col-md-4">
						<div class="input-group">
							<input type="text" class="form-control" name="eventname" id="eventname" placeholder="Enter Event Name" value="{{ Input::old('eventname') }}" required>
						</div>
					</div>
					<div class="alert alert-danger col-md-5">{{ Session::get('error')['eventname']['0'] }}</div>
				@else 
					<div class="col-md-9">
						<div class="input-group">
							<input type="text" class="form-control" name="eventname" id="eventname" placeholder="Enter Event Name" value="{{ Input::old('eventname') }}" required>
						</div>
					</div>
				@endif
			</div>
			<div class="form-group form-inline has-feedback">
				<label class="col-md-3" for="appointment">Appointment Time*</label>
				@if (Session::has('error') && array_key_exists('appointment', Session::get('error')) && !is_null(Session::get('error')['appointment']) && array_key_exists('0', Session::get('error')['appointment']) && !is_null(Session::get('error')['appointment']['0']))
					<div class="col-md-4">
						<div class="input-group">
							<input type="datetime-local" class="form-control" id="appointment" name="appointment" placeholder="Enter Appointment Time" value="{{ Input::old('appointment') }}" required>
						</div>
					</div>
					<div class="alert alert-danger col-md-5">{{ Session::get('error')['appointment']['0'] }}</div>
				@else 
					<div class="col-md-9">
						<div class="input-group">
							<input type="datetime-local" class="form-control" id="appointment" name="appointment" placeholder="Enter Appointment Time" value="{{ Input::old('appointment') }}" required>
						</div>
					</div>
				@endif
			</div>
			<div class="form-group form-inline has-feedback">
				<label class="col-md-3" for="description">Description*</label>
				@if (Session::has('error') && array_key_exists('description', Session::get('error')) && !is_null(Session::get('error')['description']) && array_key_exists('0', Session::get('error')['description']) && !is_null(Session::get('error')['description']['0']))
					<div class="col-md-4">
						<div class="input-group">
							<textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter Description" value="{{ Input::old('description') }}" required></textarea>
						</div>
					</div>
					<div class="alert alert-danger col-md-5">{{ Session::get('error')['description']['0'] }}</div>
				@else 
					<div class="col-md-9">
						<div class="input-group">
							<textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter Description" value="{{ Input::old('description') }}" required></textarea>
						</div>
					</div>
				@endif
			</div>
			<div class="form-group form-inline has-feedback">
				<label class="col-md-3" for="startplace">Start Place*</label>
				@if (Session::has('error') && array_key_exists('startplace', Session::get('error')) && !is_null(Session::get('error')['startplace']) && array_key_exists('0', Session::get('error')['startplace']) && !is_null(Session::get('error')['startplace']['0']))
					<div class="col-md-4">
						<div class="input-group">
							<input type="text" class="form-control" name="startplace" id="startplace" placeholder="Enter Start Place" value="{{ Input::old('startplace') }}" required>
						</div>
					</div>
					<div class="alert alert-danger col-md-5">{{ Session::get('error')['startplace']['0'] }}</div>
				@else 
					<div class="col-md-9">
						<div class="input-group">
							<input type="text" class="form-control" name="startplace" id="startplace" placeholder="Enter Start Place" value="{{ Input::old('startplace') }}" required>
						</div>
					</div>
				@endif
			</div>
			<div class="form-group form-inline has-feedback">
				<label class="col-md-3" for="endplace">End Place*</label>
				@if (Session::has('error') && array_key_exists('endplace', Session::get('error')) && !is_null(Session::get('error')['endplace']) && array_key_exists('0', Session::get('error')['endplace']) && !is_null(Session::get('error')['endplace']['0']))
					<div class="col-md-4">
						<div class="input-group">
							<input type="text" class="form-control" name="endplace" id="endplace" placeholder="Enter End Place" value="{{ Input::old('endplace') }}" required>
						</div>
					</div>
					<div class="alert alert-danger col-md-5">{{ Session::get('error')['endplace']['0'] }}</div>
				@else 
					<div class="col-md-9">
						<div class="input-group">
							<input type="text" class="form-control" name="endplace" id="endplace" placeholder="Enter End Place" value="{{ Input::old('endplace') }}" required>
						</div>
					</div>
				@endif
			</div>
			<div class="form-group form-inline has-feedback">
				<label class="col-md-3" for="map">Pathway Map*</label>
				<div class="col-md-9">
					<div class="input-group">
						<a href="#" class="btn btn-default" data-toggle="modal" data-target="#drawline">Add Map</a>
					</div>
				</div>
			</div>
			<div class="modal fade" id="drawline" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title" id="myModalLabel">Pathway Map</h4>
						</div>
						<div class="modal-body">
							<div id="googleMap" align="middle" style="width:500px;height:380px;"></div>
						</div>
						<div class="modal-footer">
							<button type="button" id="resetmap" class="btn btn-default">Reset</button>
							<button type="button" id="undomap" class="btn btn-default">Undo</button>
							<button type="button" class="btn btn-primary" id="savemap" data-dismiss="modal">Save</button>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="mapvalue" id="mapvalue" required>
			<input type="submit" name="submit" id="submit" value="Create" class="btn btn-info">
		</div>
	</form>
</div>
<script src="https://cdn.ckeditor.com/4.4.6/standard-all/ckeditor.js"></script>
<script>
	CKEDITOR.replace( 'description', {
		height: 150
	});
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>	
<script>
	var map;
	var markers = [];
	var poly;
	var idcounter = 0;
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

		google.maps.event.addListener(map, 'click', function(event) {
			var path = poly.getPath();
			path.push(event.latLng);
			var marker = new google.maps.Marker({
				id: idcounter++,
				position: event.latLng,
				map: map,
				animation: google.maps.Animation.DROP
			});
			markers.push(marker);
		});

	}
	google.maps.event.addDomListener(window, 'load', initialize);

	$(function(){
		$("#drawline").on("shown.bs.modal",function(){
			google.maps.event.trigger(map, 'resize');
			map.setCenter(new google.maps.LatLng(13.872273, 100.523307));
			map.setZoom(10);
		});
		$("#resetmap").click(function(){
			console.log("reset");
			var path = poly.getPath();
			for (var i = 0; i < markers.length; i++) {
				markers[i].setMap(null);
			}
			markers = [];
			path.clear();
			idcounter = 0;
		});
		$("#undomap").click(function(){
			console.log("undo");
			if(idcounter > 0) {
				var path = poly.getPath();
				path.pop();
				markers[--idcounter].setMap(null); 
				markers.pop();
			}
		});
		$("#savemap").click(function(){
			var line = "LINESTRING(";
			for (var i = 0; i < markers.length; i++) {
				line = line + markers[i].getPosition().lat() + " " + markers[i].getPosition().lng();
				if (i != markers.length - 1) {
					line = line + ",";
				}
			}
			line = line + ")";
			console.log(line);
			$("#mapvalue").attr("value", line);
		});
	});
</script>
@stop