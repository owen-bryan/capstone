<div class="container-fluid col-md-10 col-md-offset-1">
	<div class="row">
		<div class="container col-md-3">
			<div class="panel panel-default">
				<div class="container-fluid">
					<div class="row">
						<div class="container col-md-10">
							<p><strong>Category:</strong></p>
							<ul>
								<? if(isset($category) && strtolower($category) != "all"){?>
								<li><?= ucfirst($category) ?> <a href="<?= base_url() . "index.php?" . str_replace("&category=".$category, '', $base_search) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
								<? } else { ?>
								<? if(isset($categories)){ ?>
								<? foreach($categories as $category) {?>
								<li>
									<a href="<?= base_url() . "index.php?" . $base_search . "&category=" . $category['category_name'] ?>"><?= ucfirst($category['category_name']) ?></a>
								</li>
								<? } } }?>
							</ul>
							<p><strong>Condition:</strong></p>
							<ul>
								<? if(isset($condition)){?>
								<li><?= ucfirst($condition) ?> <a href="<?= base_url() . "index.php?" . str_replace("&condition=".$condition, '', $base_search) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
								<? } else { ?>
								<? if(isset($conditions)){ ?>
								<? foreach($conditions as $condition) {?>
								<li>
									<a href="<?= base_url() . "index.php?" . $base_search . "&condition=" . $condition['item_condition'] ?>"><?= ucfirst($condition['item_condition']) ?></a>
								</li>
								<? } } }?>
							</ul>
							<p><strong>Province:</strong></p>
							<ul>
								<? if(isset($province)){?>
								<? if (isset($city)){ ?>
								<li><?= ucfirst($province) ?> <a href="<?= base_url() . "index.php?" . str_replace("&province=$province", '', str_replace("&city=$city" , '', $base_search)) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
								<? } else { ?>
								<li><?= ucfirst($province) ?> <a href="<?= base_url() . "index.php?" . str_replace("&province=".$province, '', $base_search) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
								<? } } else { ?>
								<? if(isset($provinces)){ ?>
								<? foreach($provinces as $province) {?>
								<li>
									<a href="<?= base_url() . "index.php?" . $base_search . "&province=" . $province['province'] ?>"><?= ucfirst($province['province']) ?></a>
								</li>
								<? } } }?>
							</ul>
							<? if (isset($cities) || isset($city)) { ?>
							<p><strong>City:</strong></p>
							<ul>
								<? if(isset($city)){?>
								<li><?= ucfirst($city) ?> <a href="<?= base_url() . "index.php?" . str_replace("&city=".$city, '', $base_search) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
								<? } else { ?>
								<? if(isset($cities)){ ?>
								<? foreach($cities as $city) {?>
								<li>
									<a href="<?= base_url() . "index.php?" . $base_search . "&city=" . $city['city'] ?>"><?= ucfirst($city['city']) ?></a>
								</li>
								<? } } }?>
							</ul>
							<? } ?>
							<p><strong>Manufacturer:</strong></p>
							<ul>
								<? if(isset($manufacturer)){?>
								<li><?= ucfirst($manufacturer) ?> <a href="<?= base_url() . "index.php?" . str_replace("&manufacturer=".$manufacturer, '', $base_search) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
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
								<? if(isset($brand)){?>
								<li><?= ucfirst($brand) ?> <a href="<?= base_url() . "index.php?" . str_replace("&brand=".$brand, '', $base_search) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
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
	