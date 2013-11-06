<?php ?>
<form method='POST' action ='/users/p_change_password'>
	
	Password<br>
	<input type='password' name='password'>
	<br><br>
	
	New Password<br>
	<input type='password' name='new_password'>
	<br><br>
	
	Confirm Password<br>
	<input type='password' name='confirmed_password'>
	<br><br>
	
	<?php if (isset($error)): ?>
		<div class='error'>
			<p>Update failed.  Please make sure your current password is correct and your new passwords match</p>
		</div>
		<br>
	<?php endif; ?>
	<input type='submit' value='Update'>
    <br><br>

    
</form>