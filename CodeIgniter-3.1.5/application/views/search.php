<div class="container-fluid">
	<div class="row">
		<div class="container col-md-offset-2 col-md-2">
			<div class="panel panel-default">
			
			</div>
		</div>
		
		<div class="container">
			<div class="panel panel-default col-md-8">
				<? if (isset($results)) { ?>
				<div class="row">
					<div class="container col-md-2">
						
						<img src="<?= $results['img'][1] ?>"/>
					
					</div>
					<div class="container col-md-8">
						<div class="row">
							<p><?= $results['title']?></p>
						</div>
						<div class="row">
							<p>Location: <?= $results['location']?></p>
						</div>
						<div class="row">
							<p>Date posted: <?= $results['date']?></p>
						</div>
						<div class="row">
							<p><?= $results['desc']?></p>
						</div>
						<div class="row">
							<p>Sold by:<?= $results['user']?></p>
						</div>
					</div>
					<div class="container col-md-2">
						<div class="row">
							<p><?= $results['price']?></p>
						</div>
						<div class="row">
							<p>Condition: <?= $results['condition']?></p>
						</div>
					</div>
				</div>
				<? } else { ?>
				<p>No results found</p>
				<? } ?>
			</div>
		</div>
	</div>
</div>
	