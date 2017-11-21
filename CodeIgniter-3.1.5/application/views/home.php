<div class="container col-md-4 col-md-offset-4" >
	<div class="row">
		<div class="text-center">
			<h1>Card Trader</h1>
		</div>
	</div>
	<div class="row">
		<form action="<?= base_url() . "index.php?c=search&m=display"?>" method="get" class="form-horizontal">
			<input type="hidden" value="search" name="c"/>
			<input type="hidden" value="display" name="m"/>
			<div class="row">
				<div class="">
					<div class="form-group">
						<input type="text" class="form-control col-md-4" name="search_string" id="search_string" placeholder="Enter search here"/>
					</div>
					
					<div class="form-group">
						<select name="category" class="form-control col-md-4">
							<option value="all">Choose a category</option>
						<? if (isset($categories)) { 
							foreach($categories as $row) {?>
							<option value="<?= $row['id'] ?>"><?= $row['name']?></option>
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
								<div class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4" for="price_range">Price:</label>
										<div class="col-md-4">
											<input type="text" class="form-control" id="low_price" name="low_price"/>
										</div>
										<div class="col-md-4">
											<input type="text" class="form-control" id="high_price" name="high_price"/>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-4" for="manufacturer">Manufacturer:</label>
										<div class="col-md-8">
											<select class="form-control" id="manufacturer" name="manufacturer">
												<option value="all">Select manufacturer</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" for="brand">Brand:</label>
										<div class="col-md-9">
											<select class="form-control" id="brand" name="brand" disabled>
												<option value="all">Select brand</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-md-3" for="sort">Sort by:</label>
										<div class="col-md-9">
											<select class="form-control" id="sort" name="sort" >
												<option value="newest">Newest</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<p>Hello</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
