<!doctype html>
<html>
<head>
	@include('includes.head')
</head>
<body>
<div class="container">

	<header class="row">
		@include('includes.header')
	</header>

	<div id="main" class="row" style="padding-top: 70px;padding-bottom: 70px;">

			@yield('content')

	</div>

	<footer class="row">
		@include('includes.footer')
	</footer>

</div>
</body>
</html>