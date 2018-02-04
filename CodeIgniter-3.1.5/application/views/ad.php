<div class="container-fluid col-md-8 col-md-offset-2">
	<? if(isset($message)) { ?>
	<div class="row">
		<div class= "container panel panel-default col-md-10 col-md-offset-1">
			<? if(isset($message_body))  { ?>
			<p><?= $message_body ?></p>
			<? } ?>
		</div>
	</div>
	<? }?>
	<? if(isset($sold)) { ?>
	<div class="row">
		<div class= "container panel panel-danger col-md-10 col-md-offset-1">
			<p>Click <strong><a href="<?= base_url() . "index.php?c=ad&m=sold_confirmed&ad=" . $sold_id ?>">HERE</a></strong> to mark this as sold. WARNING LISTING THIS AS SOLD CANNOT BE UNCHANGED.</p>
		</div>
	</div>
	<? }?>
	<? if(isset($delete)) { ?>
	<div class="row">
		<div class= "container panel panel-danger col-md-10 col-md-offset-1">
			<p>Click <strong><a href="<?= base_url() . "index.php?c=ad&m=delete_confirmed&ad=" . $ad_id ?>">HERE</a></strong> to delete this Ad. WARNING DELETION CANNOT BE UNCHANGED.</p>
		</div>
	</div>
	<? }?>
	<div class="container col-md-12 panel panel-default">
		<div class="row">
			<div class="col-md-8">
				<h3><?= $details['ad_title']?></h2>
			</div>
			<div class="col-md-4 text-right">
				<h3>Sold by: <a href="<?= base_url() . "index.php?c=search&m=display&user=".  $details['user_name'] ?>"><?= $details['user_name'] ?></a></h3>
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
					<? if($this->ion_auth->logged_in()) { ?>
					<a href="<?= base_url() . "index.php?c=messages&m=new_message&ad_id=" . $details['ad_id'] . "&user=" . $details['id'] . "&username=". $details['user_name']?>" class="col-md-12 btn btn-primary">Contact user</a>
					<?  ?>
					<? if($details['id'] == $this->ion_auth->user()->row()->id){ ?>
					
					<a href="<?= base_url() . "index.php?c=edit&m=edit_ad&ad=".$details['ad_id'] ?>" class="col-md-12 btn btn-default">Edit</a>
					<a href="<?= base_url() . "index.php?c=ad&m=sold&ad=".$details['ad_id'] ?>" class="col-md-12 btn btn-default">Mark as sold</a>
					<a href="<?= base_url() . "index.php?c=ad&m=delete_ad&ad=".$details['ad_id'] ?>" class="col-md-12 btn btn-danger">Delete ad</a>
					<? } ?>
					<? if($admin && $details['reported']) { ?>
					<a href="<?= base_url() . "index.php?c=admin&m=forgive_user&user=" . $details['id'] . "&ad=" . $details['ad_id']?>" class="col-md-12 btn btn-success">Forgive user</a>
					<a href="<?= base_url() . "index.php?c=admin&m=ban_user&user=" . $details['id'] ?>" class="col-md-12 btn btn-danger">Ban user</a>
					<? } }?>
				</div>
			</div>
			<div class="row">
				<div class="text-left col-md-9">
				<? if($details['user_name'] != $username){?>
					<a href="<?= base_url() . "index.php?c=ad&m=report_ad&ad=" .$details['ad_id'] ?>">Report this ad</a>
				<? }?>
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
