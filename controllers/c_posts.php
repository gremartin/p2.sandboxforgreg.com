<?php
class posts_controller extends base_controller {

	public function __construct() {
		parent::__construct();
		#check if user is logged in before being able to use
		if(!$this->user){
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
				posts.content,
				posts.created,
				posts.user_id AS post_user_id,
				users_users.user_id AS follower_id,
				users.first_name,
				users.last_name
			FROM posts
			INNER JOIN users_users
				ON posts.user_id = users_users.user_id_followed
			INNER JOIN users
				ON posts.user_id = users.user_id
			WHERE users_users.user_id = ".$this->user->user_id;
		#test to see if SQL query works
		/*
		$posts = DB::instance(DB_NAME)->select_rows($q);
		foreach($posts as $post){
		echo $post['content'];
		
		}
		*/
		# Run the query
		$posts = DB::instance(DB_NAME)->select_rows($q);
		
		# Pass data to View
		$this->template->content->posts = $posts;
		
		# Render the View
		echo $this->template;
		
		}
	public function users(){

		# Set up the view
		$this->template->content = View::instance("v_posts_users");
		$this->template->title = "Users";
		
		# Build the query to get all users
		$q = "SELECT *
			FROM users";
		
		# Execute query to get users and store resulting array in $users
		$users = DB::instance(DB_NAME)->select_rows($q);
		
		# Build query to determine users already followed
		$q = "SELECT *
			FROM users_users
			WHERE user_id = ".$this->user->user_id;
			
		# Execute this query with select_array method
		# use "users_id_followed" as index to array returned
		$connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');
		
		# pass both sets of data to the view
		$this->template->content->users		= $users;
		$this->template->content->connections	= $connections;
		
		# Render the view
		echo $this->template;
		
	}

	public function follow($user_id_followed) {

		# Prepare the data array to be inserted 
		$data = Array(
			"created" => Time::now(),
			"user_id" => $this->user->user_id,
			"user_id_followed" => $user_id_followed
			);
			
		# Do the insert
		DB::instance(DB_NAME)->insert('users_users', $data);
		
		# Send them back
		Router::redirect("/posts/users");

	}

	public function unfollow($user_id_followed) {
		# Delete this connection
		$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
		DB::instance(DB_NAME)->delete('users_users', $where_condition);
		
		# Send them back
		Router::redirect("/posts/users");
	}


} # end of controller
