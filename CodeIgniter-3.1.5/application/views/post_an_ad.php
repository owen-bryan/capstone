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
	<div class="row">
		<div class= "container panel panel-default col-md-10 col-md-offset-1">
			<h2>New ad</h2>
			<hr/>
			<form method="post" action="<?= base_url() . "index.php?c=PostAnAd&m=new_ad"?>" enctype="multipart/form-data" class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-md-3" for="title">Title*:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="title" name="title" value="<?= set_value('title');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="price">Price*:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="price" name="price" value="<?= set_value('price');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="category">Category:</label>
					<div class="col-md-6">
						<select class="form-control" id="category" name="category"/>
							<option value="">Choose a category</option>
							<? if (isset($categories)) { 
								foreach($categories as $row) {?>
								<option value="<?= $row['id'] ?>"><?= $row['name']?></option>
							<? } } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="condition">Condition*:</label>
					<div class="col-md-6">
						<select class="form-control" id="condition" name="condition"/>
							<option value="">Condition</option>
							<option value="Near mint">Near Mint</option>
							<option value="Lightly played">Lightly played</option>
							<option value="Moderately played">Moderately played</option>
							<option value="Heavily played">Heavily played</option>
							<option value="Damaged">Damaged</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="manufacturer">Manufacturer:</label>
					<div class="col-md-6">
						<select class="form-control" id="manufacturer" name="manufacturer"/>
							<option value="">Select manufacturer</option>
							<? if(isset($manufacturers)) {
							foreach($manufacturers as $manufacturer){ ?>
							<option value="<?= $manufacturer['name']?>"><?= $manufacturer['name'] ?></option>
							<? } }?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="brand">Brand:</label>
					<div class="col-md-6" >
						<select class="form-control" id="brand" name="brand" disabled>
							<option value="">Brand</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="visibility">Visibility:</label>
					<div class="col-md-6">
						<label class="radio-inline"><input type="radio" id="visibility" name="visibility" value="true" checked> Public</input></label>
						<label class="radio-inline"><input type="radio" id="visibility" name="visibility" value="false"> Private</input></label>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="description">Description:</label>
					<div class="col-md-6">
						<textarea class="form-control"  rows="5" id="description" name="description"><?= set_value('description');?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="image">Item Picture:</label>
					<div class="col-md-6">
						<input type="file" class="form-control" name="image" id="image" value="<? set_value('image') ?>"/>
					</div>
				</div>
				<div class="form-group">
					<p class="text-center">Fields with (*) are required</p>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-3">
						<input type="submit" class="form-control" value="Submit"/>
					</div>
					<div class="col-md-3">
						<input type="Reset" class="form-control btn-secondary"  value="Reset"/>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>