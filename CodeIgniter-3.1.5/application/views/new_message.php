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
				<div class="col-md-8 center-block center-fix">
					<? if(isset($error)) { ?>
					<div class="row">
						<div class= "container panel panel-danger col-md-10 col-md-offset-1">
							<?= validation_errors(); ?>
						</div>
					</div>
					<? }?>
					<div class="row">
						<form action="<?= base_url() . "index.php?c=messages&m=send"?>" method="POST" >
							<? if (isset($_GET['ad_id'])) { ?>
								<input type="hidden"  name="ad" value="<?= $ad_id ?>" />
							<? } else if(set_value('ad') != ""){?>
								<input type="hidden"  name="ad" value="<?= set_value('ad') ?>" />
							<? } ?>
							<div class="form-group">
								<label for="to">To:</label>
								<input type="text" name="to" class="form-control" <? if (isset($name)) { ?>value="<?= $name ?>" <? } else { ?> value="<?= set_value("to") ?>" <? } ?>/>
							</div>
							<div class="form-group">
								<label for="subject" >Subject:</label>
								<input type="text" class="form-control"  name="subject" value="<?= set_value("subject") ?>"/>
							</div>
							<div class="form-group">
								<label for="body" >Body:</label>
								<textarea class="form-control" rows="5"  name="body"  value="<?= set_value("body") ?>"/>
								</textarea>
							</div>
							
							<div class="form-group">
								<input type="submit" value="send" class="btn"/>
								<a href="<?= base_url() . "index.php?c=messages&m=inbox" ?>" class="btn btn-primary">Discard</a>
								
							</div>
							
						</form>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>

