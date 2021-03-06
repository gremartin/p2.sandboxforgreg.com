<?php?>
<h1 class="listHeading" >Current Users</h1>
<?php foreach($users as $user): ?>
	
	<!-- Print this user's name -->
	<h3><?=$user['first_name']?> <?=$user['last_name']?></h3>
	
	<!--If there exists a connection with this user, show an unfollow link -->
	<?php if(isset($connections[$user['user_id']])): ?>
		<a href='/posts/unfollow/<?=$user['user_id']?>'>Unfollow</a>
	
	<!-- Otherwise, show follow link -->
	<?php else: ?>
		<a href='/posts/follow/<?=$user['user_id']?>'>Follow</a>
	<?php endif; ?>
	
	<br><br>

<?php endforeach; ?>
	