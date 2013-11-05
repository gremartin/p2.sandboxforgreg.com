<?php ?>
<?php if ($messageID == 0): ?>
<p>There is already an account for that email.  Please <a href='/users/login'>log in</a> or <a href='/users/signup'>sign up</a> with a different email</p> 
<?php else: ?>
<p>All fields are required Please <a href='/users/signup'>sign up</a> again</p> 
<?php endif; ?>