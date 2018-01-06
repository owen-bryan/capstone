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
					<div class="well">
						<a href="<?= base_url(). "index.php?c=messages&m=new_message" ?>">New message</a>
					</div>
					<? if ($admin){ ?>
					<div class="well">
						<a href="<?= base_url(). "index.php?c=admin&m=messages" ?>">View reported messages</a>
					</div>
					<? } ?>
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
							<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="<?= base_url() . "index.php?c=messages&m=reply&mid=" . $message['message_id'] . "&username=" .  $message['user_name']   ?>">Reply</a></li>
								<li><a href="<?= base_url() . "index.php?c=messages&m=report&mid=" . $message['message_id'] ?>">Report</a></li>
							</ul>
						</div>
					</div>
					<div class="row">
						<p>From:</p>
					</div>
					<div class="row well">
						<p><?= $message['user_name'] ?></p>
					</div>
					<div class="row">
						<p>Subject:</p>
					</div>
					<div class="row well">
						<p><?= $message['subject'] ?></p>
					</div>
					<div class="row">
						<p>Message:</p>
					</div>
					<div class="row well">
						<p><?= $message['message'] ?></p>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
</div>

