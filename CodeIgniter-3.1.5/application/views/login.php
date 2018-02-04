<div class="container-fluid  col-md-offset-4 col-md-4">
	<? if(isset($error)) { ?>
	<div class="row">
		<div class="container panel panel-danger col-md-offset-1 col-md-10">
			<? if(isset($error_msg)) { ?>
			<p class="text-danger"><?= $error_msg ?></p>
			<? } ?>
		</div>
	</div>
	<? } ?>
	<? if(isset($success)) { ?>
	<div class="row">
		<div class="container panel panel-success col-md-offset-1 col-md-10">
			<? if(isset($success_msg)) { ?>
			<p class="text-success"><?= $success_msg ?></p>
			<? } ?>
		</div>
	</div>
	<? } ?>
	<div class="row">
		<div class= "container panel panel-default col-md-10 col-md-offset-1">
			<h2>Log in</h2>
			<hr/>
			<form method="post" action="<?= base_url() . "index.php?c=Login&m=login"?>" class="form-horizontal">
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
						<a href="<?= base_url() . "index.php?c=Login&m=forgot_password" ?>">I forgot my password</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>