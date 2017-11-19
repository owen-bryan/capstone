<div class="container col-md-offset-3 col-md-6">
	<div class="row">
		<div class= "container panel panel-default col-md-10">
			<h2>Sign up complete</h2>
			<hr/>
			<div class="col-md-6 col-md-offset-3">
				<p>Thank you <?= $name?> for signing up</p>
				<p>Your username is: <?= $uname ?></p>
			</div>
			<div class="col-md-4 col-md-offset-4">
				<a href="<?= base_url() . "index.php?/Login" ?>">Log in</a>
			</div>
		</div>
	</div>
</div>