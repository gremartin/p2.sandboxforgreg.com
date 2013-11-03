<?php
class posts_controller extends base_controller {

	public function __contruct() {
		parent::__contruct();
		
		#check if user is logged in before being able to use
		if(!$this->user)	{
			die("Members only. <a href='/users/login'>Login</a>");
		}	
	}
	public function add() {
		
		#Setup view
		$this->template->content = View::instance('v_posts_add');
		$this->template->title = "New Post";
		
		# Render template
		echo $this->template;
		
	}

public function p_add() {
		# Associate this post with this user
		$_POST['user_id'] = $this->user->user_id;
		
		# Create created and modified timestamps
		$_POST['created'] = Time::now();
		$_POST['modified'] = Time::now();
		
		# Insert (no sanitization needed with this function
		DB::instance(DB_NAME)->insert('posts', $_POST);
		
		#temporary feedback message
		echo "Your post has been added.  <a href='/posts/add'>Add another</a>";
	}
public function index(){
	# Set up the View
	$this->template->content = View::instance('v_posts_index');
	$this->template->title	= "Posts";
	
	#	Build the query
	$q = "SELECT
			posts .*,
			users.first_name,
			users.last_name
		FROM posts
		INNER JOIN users
			ON posts.user_id = users.user_id";
	
	# Run the query
	$posts = DB::instance(DB_NAME)->select_rows($q);
	
	# Pass data to View
	$this->template->content->posts = $posts;
	
	# Render the View
	echo $this->template;
	
	}
	


} # end of controller
