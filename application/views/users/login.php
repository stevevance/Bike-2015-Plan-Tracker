<h2>Login</h2>

<?php  echo validation_errors(); ?>

<?php echo form_open('users/login') ?>

	<label for="title">Email</label> 
	<input type="input" name="email" /><br />

	<label for="text">Password</label>
	<input type="password" name="password" /><br />
	
	<input type="submit" name="submit" value="Login" /> 

</form>