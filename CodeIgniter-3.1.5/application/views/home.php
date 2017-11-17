
<div class="container col-md-4 col-md-offset-4" >
	<div class="row">
		<div class="text-center">
			<h1>Card Trader</h1>
		</div>
	</div>
	<div class="row">
		<form action="<?= base_url() . "index.php?/Search"?>" method="post" class="form-horizontal">
			<div class="row">
				<div class="">
					<div class="form-group">
						<input type="text" class="form-control col-md-4" name="search_string" id="search_string" placeholder="Enter search here"/>
					</div>
					
					<div class="form-group">
						<select name="categories" class="form-control col-md-4">
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
								<div class="col-md-4">
									<p>Hello</p>
								</div>
								<div class="col-md-4">
									<p>Hello</p>
								</div>
								<div class="col-md-4">
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
