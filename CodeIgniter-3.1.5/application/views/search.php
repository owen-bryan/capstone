<div class="container-fluid">
	<div class="row">
		<div class="container col-md-offset-2 col-md-2">
			<div class="panel panel-default">
			
			</div>
		</div>
		
		<div class="container">
			<div class="panel panel-default col-md-8">
				<? if (isset($results)) { 
					foreach($results as $row){
				?>
				<div class="row">
					<div class="container col-md-2">
						
						<img src="<?= $row['img']?>"/>
					
					</div>
					<div class="container col-md-8">
						<div class="row">
							<p><?= $row['title']?></p>
						</div>
						<div class="row">
							<p>Location: <?= $row['location']?></p>
						</div>
						<div class="row">
							<p>Date posted: <?= $row['date']?></p>
						</div>
						<div class="row">
							<p><?= $row['desc']?></p>
						</div>
						<div class="row">
							<p>Sold by:<?= $row['user']?></p>
						</div>
					</div>
					<div class="container col-md-2">
						<div class="row">
							<p><?= $row['price']?></p>
						</div>
						<div class="row">
							<p>Condition: <?= $row['condition']?></p>
						</div>
					</div>
				</div>
				<? } 
				} else { ?>
				<p>No results found</p>
				<? } ?>
			</div>
		</div>
	</div>
</div>
	