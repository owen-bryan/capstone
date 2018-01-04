<div class="container col-md-offset-3 col-md-6">
	<? if(isset($error)) { ?>
	<div class="row">
		<div class= "container panel panel-danger col-md-10 col-md-offset-1">
			<? if(isset($error_msg))  { ?>
			<p><?= $error_msg ?></p>
			<? } ?>
			<?= validation_errors(); ?>
		</div>
	</div>
	<? }?>
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
			<h2>New Manufacturer</h2>
			<hr/>
			<form method="post" action="<?= base_url() . "index.php?c=admin&m=new_manufacturer"?>" class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-md-3" for="manufacturer">Manufacturer:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="manufacturer" name="manufacturer" value="<?= set_value('manufacturer');?>"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-3">
						<input type="submit" class="form-control btn-primary" value="Submit"/>
					</div>
					<div class="col-md-3">
						<a href="<?= base_url() . "index.php?c=admin"?>" class="btn btn-default">Cancel</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>