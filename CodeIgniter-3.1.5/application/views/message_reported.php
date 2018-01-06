<div class="col-md-8 center-block center-fix">
	<?if (isset($alert)){?>
	<div class="row">
		<p><?= $alert ?></p>
	</div>
	<? } ?>
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-body">
				<h2><?= $title ?></h2>
				<hr/>
			
		
				<div class="col-md-3">
					<div class="well">
						<a href="<?= base_url(). "index.php?c=messages&m=inbox" ?>">Inbox</a>
					</div>
					<div class="well">
						<a href="<?= base_url(). "index.php?c=messages&m=sent" ?>">Sent</a>
					</div>
					<? if ($admin){ ?>
					<div class="well">
						<a href="<?= base_url(). "index.php?c=admin&m=messages" ?>">View reported messages</a>
					</div>
					<? } ?>
				</div>
				<div class="col-md-9">
					<table class="table table-striped table-bordered table-condesed table-hover">
						<thead>
							<td>From:</td>
							<td>Subject:</td>
							<td>Date Sent:</td>
							<td>Action:</td>
						</thead>
						<tbody>
							<? if (isset($messages)){ ?>
							<? foreach($messages as $message) { ?>
							<tr>
								<td><?= $message['user_name'] ?></td>
								<td><?= $message['subject'] ?></td>
								<td><?= $message['date_sent'] ?></td>
								<td>
									<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li><a href="<?= base_url() . "index.php?c=admin&m=forgive_user&mid=" . $message['message_id'] . "&user=" .$message['from_user_id'] ?>">Forgive</a></li>
											<li><a href="<?= base_url() . "index.php?c=admin&m=ban_user&user=" . $message['message_id'] ?>">Ban</a></li>
										</ul>
									</div>
								</td>
								
							</tr>
							<? } }?>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div>
</div>

