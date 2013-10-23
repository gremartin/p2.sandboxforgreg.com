<?php
class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
        echo "users_controller construct called<br><br>";
    } 

    public function index() {
        echo "This is the index page";
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
		# Insert user into database
		$_POST['created'] = Time::now();
		$_POST['modified'] = Time::now();
		
		#Encrypt password
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
		
		#Create an encrypted token via user's email address and random string
		$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());
		
		$user_id = DB::instance(DB_NAME)->insert('users', $_POST);
		# Confirm user is signed up.  SHould make real view eventually
		echo 'You\'re signed up';
		
	}
	
    public function login() {
        echo "This is the login page";
    }

    public function logout() {
        echo "This is the logout page";
    }

    public function profile($user_name = NULL) {        
		/*
		If you look at _v_template you'll see it prints a $content variable in the <body>
		Knowing that, let's pass our v_users_profile.php view fragment to $content so 
		it's printed in the <body>
		*/
		$this->template->content = View::instance('v_users_profile');

		# $title is another variable used in _v_template to set the <title> of the page
		$this->template->title = "Profile";

		# Pass information to the view fragment
		$this->template->content->user_name = $user_name;

		# Render View
		echo $this->template;
    }

} # end of the class