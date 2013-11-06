<?php
class users_controller extends base_controller{

    public function __construct(){
        parent::__construct();
        #echo "users_controller construct called<br><br>";
    } 

    public function signup() {
       #Setup view
		$this->template->content = View::instance('v_users_signup');
		$this->template->title = "Sign Up";
		#Render template
		echo $this -> template;
    }
	
	public function p_signup() {
		# Displays POST data from form
		/*
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
		*/
		# see if user already has account
		# build query
		$q = "SELECT email
			FROM users
			WHERE
				email =  '".$_POST['email']."'";
		
		$emailTest = DB::instance(DB_NAME)->select_field($q);
		if($emailTest) {
			$messageID = 0;
			$this->template->content = View::instance('v_users_signup_error');
			$this->template->title = "Sign up Error";
			
			$this->template->content->messageID = $messageID;
			echo $this->template;
		}
		else if($_POST['first_name'] == NULL OR $_POST['last_name'] == NULL OR $_POST['email'] == NULL OR $_POST['password'] == NULL){
			$this->template->content = View::instance('v_users_signup_error');
			$this->template->title = "Sign up Error";
			$messageID = 1;
			$this->template->content->messageID = $messageID;
			echo $this->template;
		}
		else{
			# Insert user into database
			$_POST['created'] = Time::now();
			$_POST['modified'] = Time::now();
			
			#Encrypt password
			$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
			
			#Create an encrypted token via user's email address and random string
			$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
			
			$user_id = DB::instance(DB_NAME)->insert('users', $_POST);
			# Confirm user is signed up.  SHould make real view eventually
			#echo 'You\'re signed up';
			#create variable to hold token value
			$token = $_POST['token'];
			#log user in
			setcookie("token", $token, strtotime('+1 year'), '/');			
			
			
			Router::redirect("/users/confirm");
			
		}
	}
	public function confirm()
	{		#set user up to follow themselves
			$data = Array(
			"created" => Time::now(),
			"user_id" => $this->user->user_id,
			"user_id_followed" => $this->user->user_id
			);
			#insert connection in users-users table
			DB::instance(DB_NAME)->insert('users_users', $data);
			$this->template->content = View::instance('v_users_signup_confirm');
			$this->template->title = "Signup Successful";
			echo $this->template;
			
	}
    public function login($error = NULL)	{
		# Setup view
			$this->template->content = View::instance('v_users_login');
			$this->template->title = "Login";
			# send error info to view
			$this->template->content->error = $error;
		# Render template
			echo $this->template;
	}
	
	public function p_login()	{
		# Sanitize user data
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
		
		# Hash submitted password to match DB
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
	
		# Search for email and password in db.  Retrieve token if found.
		$q = "SELECT token
			FROM users
			WHERE email = '".$_POST['email']."'
			AND password = '".$_POST['password']."'";
			
		$token = DB::instance(DB_NAME)->select_field($q);
		
		# if token not found, login failed
		
		if(!$token) {
		
			#return user to login page
			Router::redirect("/users/login/error");
			
		# But if we did, login succeeded! 
		}else {
		
		/* 
        Store this token in a cookie using setcookie()
        Important Note: *Nothing* else can echo to the page before setcookie is called
        Not even one single white space.
        param 1 = name of the cookie
        param 2 = the value of the cookie
        param 3 = when to expire
        param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
        */
		setcookie("token", $token, strtotime('+1 year'), '/');
		
		#Send user to main page or wherever I prefer
		Router::redirect("/");
		}
		
	}

    public function logout() {
        
		# Generate and save a new token for next login
		$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

		# Create the data array we'll use with the update method
		# In this case, we're only updating one field, so our array only has one entry
		$data = Array("token" => $new_token);

		# Do the update
		DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

		# Delete their token cookie by setting it to a date in the past - effectively logging them out
		setcookie("token", "", strtotime('-1 year'), '/');

		# Send them back to the main index.
		Router::redirect("/");

    }

    public function profile() {        
		/*
		If you look at _v_template you'll see it prints a $content variable in the <body>
		Knowing that, let's pass our v_users_profile.php view fragment to $content so 
		it's printed in the <body>
		
		$this->template->content = View::instance('v_users_profile');

		# $title is another variable used in _v_template to set the <title> of the page
		$this->template->title = "Profile";

		# Pass information to the view fragment
		$this->template->content->user_name = $user_name;

		# Render View
		echo $this->template;
		*/
		
    # If user is blank, they're not logged in; redirect them to the login page
		if(!$this->user) {
			Router::redirect('/users/login');
		}

		# If they weren't redirected away, continue:

		# Setup view
		$this->template->content = View::instance('v_users_profile');
		$this->template->title   = "Profile of ".$this->user->first_name;
		$signupDate = Time::display($this->user->created, 'm-d-Y');
		$this->template->content->signupDate = $signupDate;
		# Render template
		echo $this->template;
			
    }
	public function change_password ($error = NULL){
		$this->template->content = View::instance('v_users_change_password');
		$this->template->title   = "Change Password";
		# send error info to view
		$this->template->content->error = $error;
		# Render template
		echo $this->template;
	}
	
	public function p_change_password (){
		# sanitize data from user
		$_POST=DB::instance(DB_NAME)->sanitize($_POST);
		# hash submitted password
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);		
		$q = "SELECT password
				FROM users
				WHERE email = '".$this->user->email."'
				AND password = '".$_POST['password']."'";
		$password = DB::instance(DB_NAME)->select_field($q);
		if($password != $_POST['password']){
			Router::redirect('/users/change_password/error');
			}
		else if($_POST['new_password'] != $_POST['confirmed_password']){
			Router::redirect('/users/change_password/error');
		}
		else{
			# hash submitted new password
			$_POST['new_password'] = sha1(PASSWORD_SALT.$_POST['new_password']);
			$data = Array('password' => $_POST['new_password']);
			DB::instance(DB_NAME)->update_row('users', $data, "WHERE user_id = '".$this->user->user_id."'");
			Router::redirect('/users/password_confirmation');
		}
	}
	public function password_confirmation(){
		$this->template->content = View::instance('v_users_password_confirmation');
		$this->template->title = "Password Changed";
		echo $this->template;
		
	}

} # end of the class