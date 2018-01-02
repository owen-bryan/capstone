<div class="container-fluid  col-md-offset-4 col-md-4">
	<div class="row">
		<div class= "container panel panel-default col-md-10 col-md-offset-1">
			<h2>Password Recovery:</h2>
			<hr/>
			<form method="post" action="<?= base_url() . "index.php?c=Login&m=forgot_password_question"?>" class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-md-3" for="uname">User Name:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="uname" name="uname"/>
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