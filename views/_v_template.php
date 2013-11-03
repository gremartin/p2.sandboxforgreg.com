<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<!-- Common CSS -->
	<link rel="stylesheet" href="/css/tersewords.css"> 
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>	
	
	<div id="page">
		
		<div id ='header'>			
			<a href ='/'><img src = "../images/tersewords-logo.gif" alt="Terse Words" id = 'logo'/></a>
			<div id = 'menu'>	
				<?php if($user) echo 'Hello, '.$user->first_name.'!'?>
					
				<a href='/'>Home</a>
				
				<!-- Menu for logged in users -->
				<?php if($user): ?>
					<a href='/posts/add'>Post</a>
					<a href='/posts/index'>View Posts</a>
					<a href='/posts/users'>View Users</a>
					<a href='/users/logout'>Logout</a>
					<a href='/users/profile'>Profile</a>
				<?php else: ?>
				<!-- Menu for users not logged in -->
					<a href='/users/signup'>Sign up</a>
					<a href='/users/login'>Log in</a>
					
				<?php endif; ?>
			</div>  <!-- end menu div-->
		</div>	<!--end header div-->
		
		<br>
		
		<?php if(isset($content)) echo $content; ?>

		<?php if(isset($client_files_body)) echo $client_files_body; ?>
	</div>
</body>
</html>