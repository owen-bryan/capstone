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
								<li><?= ucfirst($_GET['category']) ?></li>
								<? } else { ?>
								<? if(isset($categories)){ ?>
								<? foreach($categories as $category) {?>
								<li>
									<a href="<?= base_url() . "index.php?" . $base_search . "&category=" . $category['category'] ?>"><?= ucfirst($category['category']) ?></a>
								</li>
								<? } } }?>
							</ul>
							<p><strong>Condition:</strong></p>
							<p><strong>Province:</strong></p>
							<ul>
								<? if(isset($_GET['province'])){?>
								<li><?= ucfirst($_GET['province']) ?></li>
								<? } else { ?>
								<? if(isset($provinces)){ ?>
								<? foreach($provinces as $province) {?>
								<li>
									<a href="<?= base_url() . "index.php?" . $base_search . "&province=" . $province['province'] ?>"><?= ucfirst($province['province']) ?></a>
								</li>
								<? } } }?>
							</ul>
							<p><strong>city:</strong></p>
							<ul>
								<? if(isset($_GET['city'])){?>
								<li><?= ucfirst($_GET['city']) ?></li>
								<? } else { ?>
								<? if(isset($cities)){ ?>
								<? foreach($cities as $city) {?>
								<li>
									<a href="<?= base_url() . "index.php?" . $base_search . "&city=" . $city['city'] ?>"><?= ucfirst($city['city']) ?></a>
								</li>
								<? } } }?>
							</ul>
							<p><strong>Manufacturer:</strong></p>
							<ul>
								<? if(isset($_GET['manufacturer'])){?>
								<li><?= ucfirst($_GET['manufacturer']) ?></li>
								<? } else { ?>
								<? if(isset($manufacturers)){ ?>
								<? foreach($manufacturers as $manufacturer) {?>
								<li>
									<a href="<?= base_url() . "index.php?" . $base_search . "&manufacturer=" . $manufacturer['manufacturer'] ?>"><?= ucfirst($manufacturer['manufacturer']) ?></a>
								</li>
								<? } } }?>
							</ul>
							<p><strong>Brand:</strong></p>
							<ul>
								<? if(isset($_GET['brand'])){?>
								<li><?= ucfirst($_GET['brand']) ?></li>
								<? } else { ?>
								<? if(isset($brands)){ ?>
								<? foreach($brands as $brand) {?>
								<li>
									<a href="<?= base_url() . "index.php?" . $base_search . "&brand=" . $brand['brand'] ?>"><?= ucfirst($brand['brand']) ?></a>
								</li>
								<? } } }?>
							</ul>
							
							<p><strong>Price Range:</strong></p>
						
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container col-md-9">
			<div class="panel panel-default col-md-12">
				<div class="panel-body">
					<? if (isset($results)) { 
						foreach($results as $row){
					?>
					<div class="row">
						<div class="container-fluid">
							<div class="container col-md-3">
								
								<img class="img-responsive" src="<?= $row['img']?>"/>
							
							</div>
							<div class="container col-md-6">
								<div class="row">
									<a href="<?= base_url() . "index.php?c=ad&ad=" . $row['id']?>"><?= $row['title']?></a>
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
</div>
	