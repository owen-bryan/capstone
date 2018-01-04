<div class="container col-md-offset-3 col-md-6">
	<? if(isset($message)) { ?>
	<div class="row">
		<div class="container panel panel-danger col-md-offset-1 col-md-10">
			<? if(isset($message_body)) { ?>
			<p class="text-danger"><?= $message_body ?></p>
			<? } ?>
			<?= validation_errors(); ?>
		</div>
	</div>
	<? } ?>
	<div class="row">
		<div class= "container panel panel-default col-md-offset-1 col-md-10">
			<h2>Sign up</h2>
			<hr/>
			<form method="post" action="<?= base_url() . "index.php?c=Signup&m=add_user"?>" class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-md-3" for="uname">User Name:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="uname" name="uname" value="<?= set_value('uname');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="password">Password:</label>
					<div class="col-md-6">
						<input type="password" class="form-control" id="password" name="password" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="confirm_password">Confirm password:</label>
					<div class="col-md-6">
						<input type="password" class="form-control" id="confirm_password" name="confirm_password" />
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="sec_question">Security question:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="sec_question" name="sec_question" value="<?= set_value('sec_question');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="sec_answer">Answer:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="sec_answer" name="sec_answer" value="<?= set_value('sec_answer');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="email">Email:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="email" name="email" value="<?= set_value('email');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="confirm_email">Confirm Email:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="confirm_email" name="confirm_email" value="<?= set_value('confirm_email');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="fname">First Name:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="fname" name="fname" value="<?= set_value('fname');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="lname">Last Name:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="lname" name="lname" value="<?= set_value('lname');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="address">Address:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="address" name="address" value="<?= set_value('address');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="city">City:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="city" name="city" value="<?= set_value('city');?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="province">Province:</label>
					<div class="col-md-6">
						<select  class="form-control" id="province" name="province">
							<option value="Alberta">Alberta</option>
							<option value="British Columbia">British Columbia</option>
							<option value="Manitoba">Manitoba</option>
							<option value="New Brunswick">New Brunswick</option>
							<option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
							<option value="Northwest Territories">Northwest Territories</option>
							<option value="Nova Scotia">Nova Scotia</option>
							<option value="Nunavut">Nunavut</option>
							<option value="Ontario">Ontario</option>
							<option value="Prince Edward Island">Prince Edward Island</option>
							<option value="Quebec">Quebec</option>
							<option value="Saskatchewan">Saskatchewan</option>
							<option value="Yukon">Yukon</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-6">
						<div class="checkbox">
							<label><input type="checkbox" id="is_valid" name="is_valid" />Are you sure this information is valid</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-3">
						<input type="submit" class="form-control" value="Submit"/>
					</div>
					<div class="col-md-3">
						<input type="reset" class="form-control"  value="Reset"/>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>