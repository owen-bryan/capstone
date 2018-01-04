<div class="container col-md-offset-3 col-md-6">
	<? if(isset($error)) { ?>
	<div class="row">
		<div class="container panel panel-danger col-md-offset-1 col-md-10">
			<? if(isset($error_msg)) { ?>
			<p class="text-danger"><?= $error_msg ?></p>
			<? } ?>
			<?= validation_errors(); ?>
		</div>
	</div>
	<? } ?>
	<? if(isset($success)) { ?>
	<div class="row">
		<div class="container panel panel-success col-md-offset-1 col-md-10">
			<? if(isset($success_msg)) { ?>
			<p class="text-success"><?= $success_msg ?></p>
			<? } ?>
		</div>
	</div>
	<? } ?>
	<div class="row">
		<div class= "container panel panel-default col-md-offset-1 col-md-10">
			<h2>Edit user</h2>
			<hr/>
			<form method="post" action="<?= base_url() . "index.php?c=edit&m=edit_user_submit"?>" class="form-horizontal">
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
						<input type="text" class="form-control" id="sec_question" name="sec_question" value="<?= set_value('sec_question');?>" placeholder="<?= $user[0]['recovery_question'] ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="sec_answer">Answer:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="sec_answer" name="sec_answer" value="<?= set_value('sec_answer');?>" placeholder="<?= $user[0]['recovery_answer'] ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="email">Email:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="email" name="email" value="<?= set_value('email');?>" placeholder="<?= $user[0]['email'] ?>"/>
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
						<input type="text" class="form-control" id="fname" name="fname" value="<?= set_value('fname');?>"  placeholder="<?= $user[0]['first_name'] ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="lname">Last Name:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="lname" name="lname" value="<?= set_value('lname');?>"  placeholder="<?= $user[0]['last_name'] ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="address">Address:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="address" name="address" value="<?= set_value('address');?>"  placeholder="<?= $user[0]['address'] ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="city">City:</label>
					<div class="col-md-6">
						<input type="text" class="form-control" id="city" name="city" value="<?= set_value('city');?>"  placeholder="<?= $user[0]['city'] ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3" for="province">Province:</label>
					<div class="col-md-6">
						<select  class="form-control" id="province" name="province">
							<option value="">Province</option>
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
							<label><input type="checkbox" id="is_valid" name="is_valid" />Are you sure you wish to make these changes</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-3">
						<input type="submit" class="form-control" value="Submit"/>
					</div>
					<div class="col-md-3">
						<input type="Reset" class="form-control"  value="Reset"/>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>