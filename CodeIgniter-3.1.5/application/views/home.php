
<div class="container-fluid" >
	<div class="row">
		<div class="center-block" >
			<div class="row">
				<h1 class="text-center">Card Trader</h1>
			</div>
			<div class="row">
				<div class="center-block">
					<form action="<?= base_url() . "index.php?/Search"?>" method="post">
						<div class="row">
							<div class="center-block">
								<input type="text" placeholder="Enter search here"/>
								<select name="categories">
									<option value="all">Choose a category</option>
								</select>
								<input type="submit" value="Search"/>
							</div>
						</div>
						<div class="row">
							<div class="text-center">
								<a href="#" id="show_more">Click here for advanced options</a><br/>
							</div>
						</div>
						<div class="row">
							<div id="advanced_options" class="container col-md-9 hidden">
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
	</div>
</div>
