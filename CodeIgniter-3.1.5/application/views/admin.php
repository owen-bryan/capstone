<div class="container-fluid  col-md-offset-4 col-md-4">
	<div class="row">
		<div class= "container panel panel-default col-md-12 ">
			<h2>Admin</h2>
			<hr/>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-5 center-block center-fix">
						<a href="<?= base_url() . "index.php?c=admin&m=messages" ?>" class="btn btn-primary">View user reported messages</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-5 center-block center-fix">
						<a href="<?= base_url() . "index.php?c=search&m=display&reported=true" ?>" class="btn btn-primary">View user reported ads</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 center-block center-fix">
						<a href="<?= base_url() . "index.php?c=Admin&m=category" ?>" class="btn btn-primary">Add new category</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-5 center-block center-fix">
						<a href="<?= base_url() . "index.php?c=Admin&m=brand" ?>" class="btn btn-primary">Add new  brand</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-5 center-block center-fix">
						<a href="<?= base_url() . "index.php?c=Admin&m=manufacturer" ?>" class="btn btn-primary">Add new manufacturer</a>
					</div>
				</div>
			
			</div>
		</div>
	</div>
</div>