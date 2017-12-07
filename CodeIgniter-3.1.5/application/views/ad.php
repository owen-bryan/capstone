<div class="container-fluid col-md-8 col-md-offset-2">
	<div class="container col-md-12 panel panel-default">
		<div class="row">
			<div class="col-md-8">
				<h3><?= $details['ad_title']?></h2>
			</div>
			<div class="col-md-4 text-right">
				<h3>Sold by: <?= $details['user_name'] ?></h3>
			</div>
		</div>
		<hr/>
		<div class="row panel-body">
			<div class= "row" >
				<div class="container col-md-3">
					<img src="<?= base_url() . "uploads/" . $details['image_location'] ?>" class="img-responsive"/> 
				</div>
				<div class="container col-md-7">
					<div class="row">
						<p>Price: $<?= $details['item_price'] ?></p>
					</div>
					<div class="row">
						<p>Location: <?= ucfirst($details['address']) . ", " . ucfirst($details['city']) . ", " . ucfirst($details['province']) ?></p>
					</div>
					<div class="row">
						<p>Date posted: <?= date("d/m/Y", strtotime($details['post_date'])) ?></p>
					</div>
					<div class="row">
						<p>Condition: <?= $details['item_condition'] ?></p>
					</div>
					<div class="row">
						<p>Description: <?= $details['item_description'] ?></p>
					</div>
				</div>
				<div class="container col-md-2">
					<a href="<?= base_url() . "index.php?c=message&m=new_message&ad_id=" . $details['ad_id'] . "&user=" . $details['id'] ?>" class="btn btn-primary">Contact this user</a>
				</div>
			</div>
			<div class="row">
				<div class="text-left col-md-9">
					<a href="<?= base_url() . "index.php?/c=ad&m=report&user=" .$details[id] ?>">Report this user</a>
				</div>
				<div class="text-right col-md-3">
					<div class="">
						<p>Views: <?= $details['views'] ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
