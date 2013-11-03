<?php ?>
<h1>Welcome to <?=APP_NAME?><?php if($user) echo ', '.$user->first_name; ?></h1>
<?php if(!$user): ?>
	<p>Please <a href='/users/signup'>Sign up</a> or <a href='/users/login'>Log in</a></p>
<?php endif; ?>

