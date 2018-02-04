<div class="container-fluid  col-md-offset-4 col-md-4">
	<? if(isset($error)) { ?>
	<div class="row">
		<div class="container panel panel-danger col-md-offset-1 col-md-10">
			<? if(isset($error_msg)) { ?>
			<p class="text-danger"><?= $error_msg ?></p>
			<? } ?>
			<?= validation_errors(); ?>
		</div>
	</div>
	<? } ?>
	<div class="row">

		<div class= "container panel panel-default col-md-10 col-md-offset-1">
			<h2>Password Recovery:</h2>
			<hr/>
			<form method="post" action="<?= base_url() . "index.php?c=Login&m=forgot_password_answer"?>" class="form-horizontal">
				<input type="hidden" id="uid" name="uid" value="<?= $uid ?>"/>
				<div class="form-group">
					<label class="control-label col-md-3">Question:</label>
					<div class="col-md-6 ">
						<p><?= $question ?></p>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="answer">Answer:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="answer" name="answer"/>
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