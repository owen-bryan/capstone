
<div class="conmtainer" >
	<div class="row">
		<div class="row">
			<h1 class="text-center">Card Trader</h1>
		</div>
		<div class="row">
			<form action="<?= base_url() . "index.php?/Search"?>" method="post" class="form-inline">
				<div class="row">
					<div class="text-center">
						<input type="text" class="form-control" placeholder="Enter search here"/>
						<select name="categories" class="form-control">
							<option value="all">Choose a category</option>
						</select>
						<input type="submit" class="btn btn-primary" value="Search"/>
					</div>
				</div>
				<div class="row">
					<div class="text-center">
						<a href="#" id="show_more">Click here for advanced options</a>
					</div>
				</div>
				<div class="row">
					<div id="advanced_options" class="container col-md-6 col-md-offset-3 hidden">
						<div class ="panel panel-default col-md-offset-1">
							<h2>Advanced Search</h2>
							<hr/>
							<div class="container">
									
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
