<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header" style="padding:0px;">
			<a class="navbar-brand" style="padding:5px 15px 5px 15px;" href="/"><img src="/img/logo.png" height="40"></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="/">Home</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Event <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="/officialevent">Official Event</a></li>
						@if($authorized)
							<li><a href="/memberevent">Member Event</a></li>
						@endif
					</ul>
				@if($authorized)
					<li><a href="/tradingzone">Trading Zone</a></li>
				@endif
			</ul>
			@if(!$authorized)
				<ul class="nav navbar-nav navbar-right">
					<!-- <li><a href="/signin"><div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div></a></li> -->
					<li><a href="/signin"><img src="/img/loginwithfacebook.png" height="27"></img></a></li>
				</ul>
			@else
				<ul class="nav navbar-nav navbar-right">
					<!-- <li><a><span><img src={{ $_SESSION['picurl'] }}></img></span><strong> {{ $_SESSION['name'] }}</strong></a></li> -->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><img src={{ $_SESSION['picurl'] }}></img></span><strong> {{ $_SESSION['name'] }}</strong><b class="caret"></b></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="/wishlist">My Wishlist</a></li>
							<!-- <li><a href="/profile">Profile</a></li> -->
							<!-- <li><a href="/cart">My Cart</a></li> -->
							<!-- <li><a href="/bid">My Bid</a></li> -->
							<!-- <li><a href="/feedback">Feedback</a></li> -->
							<!-- <li><a href="/history">History</a></li> -->
							<li class="divider"></li>
							<li><a href="/logout">Log Out</a></li>
						</ul>
					</li>
				</ul>
			@endif
		</div>
	</div>
</nav>