@extends('layouts.default')
@section('content')
<div class="container">
	<h3>My Events</h3>
	@if($mywishlists->count() == 1)
		<h3>You join 1 Event</h3>
	@else
		<h3>You join {{ $mywishlists->count() }} Events</h3>
	@endif
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th> </th>
				<th>Event</th>
			</tr>
		</thead>
		<tbody>
			@foreach($mywishlists as $key => $value)
				<tr>
					<td><img class="media-object" height='180' width='180' src={{ $value->picurl }}></td>
					<td>{{ $value->title }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div
@stop