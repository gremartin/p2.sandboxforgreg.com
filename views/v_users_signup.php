<?php ?>
<form method='POST' action ='/users/p_signup'>

	First Name<br>
	<input type='text' name='first_name'>
	<br><br>
	
	Last Name<br>
	<input type='text' name='last_name'>
	<br><br>
	
	Email<br>
	<input type='text' name='email'>
	<br><br>
	
	Password<br>
	<input type='password' name='password'>
	<br><br>
	
	<input type='hidden' name='timezone'>
	
	<script>
		$('input[name=timezone]').val(jstz.determine().name());
	</script>
	
	<input type='submit' value='Sign up'>

</form>
