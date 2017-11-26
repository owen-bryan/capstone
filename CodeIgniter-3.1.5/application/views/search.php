<div class="container-fluid col-md-10 col-md-offset-1">
	<div class="row">
		<div class="container col-md-3">
			<div class="panel panel-default">
				<div class="container-fluid">
					<div class="row">
						<div class="container col-md-10">
							<p><strong>Category:</strong></p>
							<ul>
							<? if(isset($_GET['category'])){?>
							<? 	if( $this->input->get('category') != "all" ) { ?>
								<li><?= $this->input->get('category', true); ?></li>
							<? } } ?>
							</ul>
							<p><strong>Condition:</strong></p>
							<ul>
								<li>
									<a href="<?= base_url() . "index.php?c=search&m=display&province=ontario" ?>">Ontario</a>
								</li>
							</ul>
							<ul>
							
							</ul>
							<p><strong>Location:</strong></p>
							<ul>
							
							</ul>
							<p><strong>Manufacturer:</strong></p>
							<ul>
							
							</ul>
							<p><strong>Brand:</strong></p>
							<ul>
							
							</ul>
							
							<p><strong>Price Range:</strong></p>
						
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container col-md-9">
			<div class="panel panel-default col-md-12">
				<? if (isset($results)) { 
					foreach($results as $row){
				?>
				<div class="row top15">
					<div class="container-fluid">
						<div class="container col-md-3">
							
							<img class="img-responsive" src="<?= $row['img']?>"/>
						
						</div>
						<div class="container col-md-6">
							<div class="row">
								<a href="<?= base_url() . "indext.php?/Ad/" . $row['user_id']?>"><?= $row['title']?></a>
							</div>
							<div class="row">
								<p>Location: <?= $row['location']?></p>
							</div>
							<div class="row">
								<p>Date posted: <?= $row['date']?></p>
							</div>
							<div class="row">
								<p>Sold by: <?= $row['user']?></p>
							</div>
							<div class="row" style="overflow: hidden;">
								<p><?= $row['desc']?></p>
							</div>
						</div>
						<div class="container col-md-3">
							<div class="row">
								<h4>$<?= $row['price']?></h4>
							</div>
							<div class="row">
								<p>Condition: <?= $row['condition']?></p>
							</div>
						</div>
					</div>
				</div>
				<hr/>
				<? } 
				} else { ?>
				<p>No results found</p>
				<? } ?>
			</div>
		</div>
	</div>
</div>
	