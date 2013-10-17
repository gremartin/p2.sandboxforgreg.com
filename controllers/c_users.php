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
        echo "This is the signup page";
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