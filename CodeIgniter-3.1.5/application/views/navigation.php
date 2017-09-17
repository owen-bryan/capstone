	
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<ul class= "nav navbar-nav">
				
				<? if ($page != "Home") { ?>
				<li class="nav-item"><a class="nav-link" href="header.html">Home</a></li>
				<? } ?>
				<? if (isset($loggedIn) && $loggedIn != false) { ?>
				<li class="nav-item"><a class="nav-link" href="header.html">Post an Ad</a></li>
				<li class="nav-item"><a class="nav-link" href="header.html">Messages</a></li>
				<li class="nav-item"><a class="nav-link" href="header.html">Account</a></li>
				<li class="nav-item"><a class="nav-link" href="header.html">Log out</a></li>
				<? } else {?>
				<li class="nav-item"><a class="nav-link" href="header.html">Log in</a></li>
				<li class="nav-item"><a class="nav-link" href="header.html">Sign up</a></li>
				<? } ?>
			</ul>
			
			<? if ($page != "Home") { ?>
			<form class="navbar-form navbar-right">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			</form>
			<? } ?>
		</div>
	</nav>