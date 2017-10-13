<div class="container-fluid">
	<div class="row col-md-offset-3 col-md-6">
		<div class= "container panel panel-default">
			<form method="post" action="<?= base_url() . "index.php?/Signup/addUser"?>" class="form-horizontal">
			
				<div class="form-group">
					<label class="form-label" for="uname">User Name:</label>
					<input type="text" class="form-control" id="uname" name="uname"/>
				</div>
				<div class="form-group">
					<label class="form-label" for="password">Password:</label>
					<input type="text" class="form-control" id="password" name="password"/>
				</div>
				<div class="form-group">
					<label class="form-label" for="confirm_password">Confirm password:</label>
					<input type="text" class="form-control" id="confirm_password" name="confirm_password"/>
				</div>
				<div class="form-group">
					<label class="form-label" for="sec_question">Security question:</label>
					<input type="text" class="form-control" id="sec_question" name="sec_question"/>
				</div>
				<div class="form-group">
					<label class="form-label" for="sec_answer">Answer:</label>
					<input type="text" class="form-control" id="sec_answer" name="sec_answer"/>
				</div>
				<div class="form-group">
					<label class="form-label" for="email">Email:</label>
					<input type="text" class="form-control" id="email" name="email"/>
				</div>
				<div class="form-group">
					<label class="form-label" for="confirm_email">Confirm Email:</label>
					<input type="text" class="form-control" id="confirm_email" name="confirm_email"/>
				</div>
				<div class="form-group">
					<label class="form-label" for="fname">First Name:</label>
					<input type="text" class="form-control" id="fname" name="fname"/>
				</div>
				<div class="form-group">
					<label class="form-label" for="lname">Last Name:</label>
					<input type="text" class="form-control" id="lname" name="lname"/>
				</div>
				<div class="form-group">
					<label class="form-label" for="address">Address:</label>
					<input type="text" class="form-control" id="address" name="address"/>
				</div>
				<div class="form-group">
					<label class="form-label" for="city">City:</label>
					<input type="text" class="form-control" id="city" name="city"/>
				</div>
				<div class="form-group">
					<label class="form-label" for="province">Province:</label>
					<input type="text" class="form-control" id="province" name="province"/>
				</div>
				<div class="form-group">
					<label class="form-label" for="is_valid">Are you sure this information is Valid:</label>
					<input type="checkbox" class="form-control" id="is_valid" name="is_valid" value="true"/>Yes, I am sure
				</div>
				<div class="form-group">
					<input type="submit" class="form-control" value="Submit"/>
					<input type="Reset" class="form-control"  value="Reset"/>
					
				</div>
			</form>
		</div>
	</div>

</div>