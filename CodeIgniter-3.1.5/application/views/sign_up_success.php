<div class="container col-md-offset-3 col-md-6">
	<div class="row">
		<div class= "container panel panel-default col-md-10">
			<h2>Sign up complete</h2>
			<hr/>
			<div class="panel-body">
				<div class="text-center">
					<p>Thank you <?= $name?> for signing up</p>
					<p>Your username is: <?= $uname ?></p>
				</div>
				<div class="text-center">
					<a href="<?= base_url() . "index.php?/Login" ?>">Log in</a>
				</div>
			</div>
		</div>
	</div>
</div>