<div class="container col-xs-8 col-xs-offset-2 col-md-4 col-md-offset-4" >
	<div class="row">
		<div class="text-center">
			<h1>Card Trader</h1>
		</div>
	</div>
	<div class="row">
		<form action="<?= base_url() . "index.php"?>" method="get" id="search_form" class="form-horizontal">
			<input type="hidden" value="search" name="c"/>
			<input type="hidden" value="display" name="m"/>
			<div class="row">
				<div class="">
					<div class="form-group">
						<input type="text" class="form-control col-md-4" name="search_string" id="search_string" placeholder="Enter search here"/>
					</div>
					
					<div class="form-group">
						<select name="category" class="form-control col-md-4">
							<option value="">Choose a category</option>
						<? if (isset($categories)) { 
							foreach($categories as $row) {?>
							<option value="<?= $row['name'] ?>"><?= $row['name']?></option>
						<? } } ?>
						</select>
					</div>
					
					<div class="form-group">
						<input type="submit" class="form-control btn-primary col-md-4" value="Search"/>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="text-center">
					<a href="#" id="show_more">Click here for advanced options</a>
				</div>
			</div>
			<div class="row">
				<div id="advanced_options" class="hidden">
					<div class="panel panel-default container-fluid col-md-12">
						<div >
							<h2>Advanced Search</h2>
							<hr/>
							<div class="row">
								<div class="col-md-7">
									<div class="form-group">
										<label class="control-label col-md-4" for="price_range">Price:</label>
										<div class="col-md-4">
											<input type="text" class="form-control" id="low_price" name="low_price" disabled/>
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="high_price" name="high_price" disabled/>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-4" for="manufacturer">Manufacturer:</label>
										<div class="col-md-8">
											<select class="form-control" id="manufacturer" name="manufacturer" disabled>
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
										<div class="col-md-9">
											<select class="form-control" id="brand" name="brand" disabled>
												<option value="">Select brand</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" for="sort">Sort by:</label>
										<div class="col-md-9">
											<select class="form-control" id="sort" name="sort" disabled>
												<option value="newest">Newest</option>
												<option value="oldest">Oldest</option>
												<option value="highest">Highest Price</option>
												<option value="lowest">Lowest Price</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label class="control-label col-md-3" for="province">Province:</label>
										<div class="col-md-6">
											<select class="form-control" id="province" name="province" disabled>
												<option value="">Province</option>
												<? if(isset($provinces)){
													foreach($provinces as $province) { ?>
												<option value="<?= $province ?>"><?= ucfirst($province) ?></option> 
												<? } }?>
											</select>
										</div>
										
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" for="city">City:</label>
										<div class="col-md-6">
											<select class="form-control" id="city" name="city" disabled>
												<option value="">City</option>
												<? if(isset($cities)){
													foreach($cities as $city) { ?>
												<option value="<?= $city ?>"><?= ucfirst($city) ?></option> 
												<? } }?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
