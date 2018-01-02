<div class="container-fluid  col-md-offset-4 col-md-4">
	<div class="row">
		<div class= "container panel panel-default col-md-10 col-md-offset-1">
			<h2>Password Recovery:</h2>
			<hr/>
			<form method="post" action="<?= base_url() . "index.php?c=Login&m=reset_password"?>" class="form-horizontal">
				<input type="hidden" id="uid" name="uid" value="<?= $uid ?>"/>
				<div class="form-group">
					<label class="control-label col-md-3" for="pword">Password:</label>
					<div class="col-md-6">
						<input type="password" class="form-control" id="pword" name="pword"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="pword">Confirm password:</label>
					<div class="col-md-6">
						<input type="password" class="form-control" id="pword_confirm" name="pword_confirm"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-4 col-md-4">
						<input type="submit" class="form-control" value="submit"/>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>