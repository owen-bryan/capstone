<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class= "nav navbar-nav">
				<? if ($page != "Home") { ?>
				<li><a href="<?= base_url() . "index.php?c=Home"?>">Home</a></li>
				<? } ?>
				<? if (isset($loggedIn) && $loggedIn != false) { ?>
				<li><a href="<?= base_url() . "index.php?c=PostAnAd" ?>">Post an Ad</a></li>
				<li><a href="<?= base_url() . "index.php?c=messages&m=inbox" ?>">Messages</a></li>
				<li><a href="<?= base_url() . "index.php?c=edit&m=edit_user" ?>">Account</a></li>
				<li><a href="<?= base_url() . "index.php?c=search&m=display&user=$username" ?>">My ads</a></li>
				<? if($admin){ ?>
				<li><a href="<?= base_url() . "index.php?c=Admin" ?>">Admin</a></li>
				<? } ?>
				<li><a href="<?= base_url() . "index.php?c=Login&m=log_out"?>">Log out</a></li>
				<? } else {?>
				<li><a href="<?= base_url() . "index.php?c=Login"?>">Log in</a></li>
				<li><a href="<?= base_url() . "index.php?c=Signup" ?>">Sign up</a></li>
				<? } ?>
			</ul>
			<? if ($page != "Home") { ?>
			<form class="navbar-form navbar-right" action="<?= base_url() . "index.php" ?>" method="get">
				<input type="hidden" value="search" name="c"/>
				<input type="hidden" value="display" name="m"/>
				<div class="form-group">
					<input type="text" name="search_string" class="form-control" placeholder="Search">
				</div>
				<div class="form-group">
					<button type="submit" class="form-control btn btn-default">Submit</button>
				</div>
			</form>
			<? } ?>
		</div>
	</div>
</nav>