@extends('layouts.default')
@section('content')
<div class="container">
	<h3>Member Events</h3>
	@foreach($events as $key => $value)
	<div class="well">
		<div class="media">
			<a class="pull-left" href="{{ $value->crediturl }}">
				<img class="media-object" height='180' width='180' src={{ $value->picurl }}>
			</a>
			<div class="media-body">
				<h4 class="media-heading">{{ $value->title }}</h4>
				<!-- <p class="text-right">By Francisco</p> -->
				<p>Time: {{ $value->date }}</p>
				<p>Place: {{ $value->place }}</p>
				<p>More Info: <a href="{{ $value->crediturl }}">Click</a></p>
					<ul class="list-inline list-unstyled pull-right">
						@if($authorized)
							<li>
							{{ Form::open(array('url' => '/join')) }}
								{{ Form::hidden('eventid', $value->id)}}
								{{ Form::hidden('facebookid', $_SESSION['facebookid'])}}
								{{ Form::button('<span><i class="glyphicon glyphicon-calendar"></i>Join</span>', array('type' => 'submit', 'class' => 'btn btn-submit')) }}
							{{ Form::close() }}
							</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
		@endforeach
	</div>
@stop