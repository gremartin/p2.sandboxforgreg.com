<?php?>
<h1 class="listHeading" >Posts</h1>
<?php foreach($posts as $post): ?>
	<article>
		
		<h1><?=$post['first_name']?> <?=$post['last_name']?> posted:</h1>
		
		<p><?=$post['content']?></p>
		
		<time datetime="<?=Time::display($post['created'], 'Y-m-d G:i')?>">
			<?=Time::display($post['created'])?>
		</time>
		
		<?php if($post['post_user_id'] == $post['follower_id']): ?>
		<br><a href='/posts/delete/<?=$post['post_id']?>'>Delete Post</a>
		<?php endif; ?>
	</article>
	
<?php endforeach; ?>