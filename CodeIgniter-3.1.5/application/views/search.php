<div class="container-fluid col-md-10 col-md-offset-1">
	<div class="row">
		<div class="container col-md-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="container-fluid">
						<div class="row">
							<div class="container col-md-10">

								<p><strong>Category:</strong></p>
								<ul>
									<? if(isset($current_category) && trim($current_category) != ""){?>
									<li><?= ucfirst($current_category) ?> <a href="<?= base_url() . "index.php?" . str_replace("&category=".$current_category, '', $base_search) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
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
									<? if(isset($current_condition)){?>
									<li><?= ucfirst($current_condition) ?> <a href="<?= base_url() . "index.php?" . str_replace("&condition=".$current_condition, '', $base_search) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
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
									<? if(isset($current_province)  && trim($current_province) != ""){?>
									<? if (isset($current_city)){ ?>
									<li><?= ucfirst($province) ?> <a href="<?= base_url() . "index.php?" . str_replace("&province=$current_province", '', str_replace("&city=$current_city" , '', $base_search)) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
									<? } else { ?>
									<li><?= ucfirst($current_province) ?> <a href="<?= base_url() . "index.php?" . str_replace("&province=".$current_province, '', $base_search) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
									<? } } else { ?>
									<? if(isset($provinces)){ ?>
									<? foreach($provinces as $province) {?>
									<li>
										<a href="<?= base_url() . "index.php?" . $base_search . "&province=" . $province['province'] ?>"><?= ucfirst($province['province']) ?></a>
									</li>
									<? } } }?>
								</ul>
								<? if ((isset($cities) || isset($current_city)) && trim($current_province) != "") { ?>
								<p><strong>City:</strong></p>
								<ul>
									<? if(isset($current_city)  && trim($current_city) != ""){?>
									<li><?= ucfirst($current_city) ?> <a href="<?= base_url() . "index.php?" . str_replace("&city=".$current_city, '', $base_search) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
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
									<? if(isset($current_manufacturer) && trim($current_manufacturer) != ""){?>
									<? if(isset($current_brand) && trim($current_brand) != "") { ?>
									<li><?= ucfirst($current_manufacturer) ?> <a href="<?= base_url() . "index.php?" . str_replace("&manufacturer=$current_manufacturer", '', str_replace("&brand=$current_brand" , '', $base_search)) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
									<? } else { ?>
									<li><?= ucfirst($current_manufacturer) ?> <a href="<?= base_url() . "index.php?" . str_replace("&manufacturer=$current_manufacturer", '', $base_search) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
									<? }} else { ?>
									<? if(isset($manufacturers)){ ?>
									<? foreach($manufacturers as $manufacturer) {?>
									<li>
										<a href="<?= base_url() . "index.php?" . $base_search . "&manufacturer=" . $manufacturer['manufacturer_name'] ?>"><?= ucfirst($manufacturer['manufacturer_name']) ?></a>
									</li>
									<? } } }?>
								</ul>
								<? if (isset($current_manufacturer) && trim($current_manufacturer) != "") {?>
								<p><strong>Brand:</strong></p>
								<ul>
									<? if(isset($current_brand)){?>
									<li><?= ucfirst($current_brand) ?> <a href="<?= base_url() . "index.php?" . str_replace("&brand=".$current_brand, '', $base_search) ?>"><span class="glyphicon glyphicon-remove"></span></a></li>
									<? } else { ?>
									<? if(isset($brands)){ ?>
									<? foreach($brands as $brand) {?>
									<li>
										<a href="<?= base_url() . "index.php?" . $base_search . "&brand=" . $brand['brand_name'] ?>"><?= ucfirst($brand['brand_name']) ?></a>
									</li>
									<? } } }?>
								</ul>
								<? } ?>
								<p><strong>Price Range:</strong></p>
								<form class="form-inline" method="get" action="<?= base_url() . "index.php" ?>">
									<input type="hidden" name="c" value="search" />
									<input type="hidden" name="m" value="display" />
									<input type="hidden" name="search_string" value="<?= $search_string ?>"/>
									<? if (isset($current_condition) && trim($current_condition) != "") { ?>
									<input type="hidden" name="condition" value="<?= $condition ?>" />
									<? } ?>
									
									<? if (isset($current_category) && trim($current_category) != "") { ?>
									<input type="hidden" name="category" value="<?= $category ?>" />
									<? } ?>
									<? if (isset($current_province) && trim($current_province) != "") { ?>
									<input type="hidden" name="province" value="<?= $province ?>" />
									<? } ?>
									<? if (isset($current_city) && isset($current_province) && trim($current_city) != "") { ?>
									<input type="hidden" name="city" value="<?= $city ?>" />
									<? } ?>
									<? if (isset($current_manufacturer) && trim($current_manufacturer) != "") { ?>
									<input type="hidden" name="manufacturer" value="<?= $current_manufacturer ?>" />
									<? } ?>
									<? if (isset($current_manufacturer) && isset($current_brand) && trim($current_brand) != "") { ?>
									<input type="hidden" name="brand" value="<?= $brand ?>" />
									<? } ?>
									<div class="form-group">
										<input type="text" class="form-control" name="low_price" placeholder="min"/>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="high_price" placeholder="max"/>
									</div>
									<div class="form-group">
										<input type="submit" class="form-control" value="Go" />
									</div>
								</form>
								<p><strong>Sort by:</strong></p>
								<form class="form-inline" method="get" action="<?= base_url() . "index.php" ?>">
									<input type="hidden" name="c" value="search" />
									<input type="hidden" name="m" value="display" />
									<input type="hidden" name="search_string" value="<?= $search_string ?>"/>
									<? if (isset($current_condition) && trim($current_condition) != "") { ?>
									<input type="hidden" name="condition" value="<?= $condition ?>" />
									<? } ?>
									
									<? if (isset($current_category) && trim($current_category) != "") { ?>
									<input type="hidden" name="category" value="<?= $category ?>" />
									<? } ?>
									<? if (isset($current_province) && trim($current_province) != "") { ?>
									<input type="hidden" name="province" value="<?= $province ?>" />
									<? } ?>
									<? if (isset($current_city) && isset($current_province) && trim($current_city) != "") { ?>
									<input type="hidden" name="city" value="<?= $city ?>" />
									<? } ?>
									<? if (isset($current_manufacturer) && trim($current_manufacturer) != "") { ?>
									<input type="hidden" name="manufacturer" value="<?= $current_manufacturer ?>" />
									<? } ?>
									<? if (isset($current_manufacturer) && isset($current_brand) && trim($current_brand) != "") { ?>
									<input type="hidden" name="brand" value="<?= $brand ?>" />
									<? } ?>
									<? if (isset($high_price) && trim($high_price) != "") { ?>
									<input type="hidden" name="high_price" value="<?= $high_price ?>" />
									<? } ?>
									<? if (isset($low_price) && trim($low_price) != "") { ?>
									<input type="hidden" name="low_price" value="<?= $low_price ?>" />
									<? } ?>
									<div class="form-group">
										<select class="form-control" name="sort" >
											<option value="newest">Newest</option>
											<option value="oldest">oldest</option>
										</select>
									</div>
									<div class="form-group">
										<input type="submit" class="form-control" value="Go" />
									</div>
								</form>
							</div>
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
	