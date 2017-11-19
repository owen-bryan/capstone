<div class="container-fluid  col-md-offset-4 col-md-4">
	<div class="row">
		<div class= "container panel panel-default col-md-10 col-md-offset-1">
			<h2>Log in</h2>
			<hr/>
			<form method="post" action="<?= base_url() . "index.php?/Login/login"?>" class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-md-3" for="uname">User Name:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="uname" name="uname" value="<?= set_value('uname'); ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="password">Password:</label>
					<div class="col-md-6">
						<input type="password" class="form-control" id="password" name="password"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-3">
						<input type="submit" class="form-control" value="Log in"/>
					</div>
					<div class="col-md-3">
						<input type="reset" class="form-control" value="Reset"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-6">
						<a href="<?= base_url() . "index.php?/Login/forgot_password" ?>">I forgot my password</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>