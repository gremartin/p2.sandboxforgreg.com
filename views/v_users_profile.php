<?php?>
<h1>Profile info for <?=$user->first_name?> </h1>
<ul>
	<li>First Name: <?=$user->first_name?></li>
	<li>Last Name: <?=$user->last_name?></li>
	<li>Email: <?=$user->email?></li>
	<li>Signup Date: <?=$signupDate?></time></li> 
	<br>
	<a href='/users/change_password/'>Change Password</a>