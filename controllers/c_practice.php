<?php 

class practice_controller extends base_controller {
public function test_db(){
/*
	$q = "INSERT INTO users SET
		first_name = 'Sam',
		last_name = 'Seaborn',
		email = 'seaborn@whitehouse.gov'";
	echo DB::instance(DB_NAME)->query($q);
*/
/*
	$q = "UPDATE users
	SET email = 'samseaborn@whitehouse.gov'
	WHERE email = 'seaborn@whitehouse.gov'";
	
	echo DB::instance(DB_NAME)->query($q);
*/
/*
	#Our SQl command
	$q = "DELETE FROM users
		WHERE email = 'samseaborn@whitehouse.gov'";
		
	# Run the command
	
	echo DB::instance(DB_NAME)->query($q);
*/
/*
	$data = Array
	(
		'first_name' => 'Sam',
		'last_name'  => 'Seaborn',
		'email' => 'seaborn@whitehouse.gov');
	$user_id = DB::instance(DB_NAME)->insert('users', $data);
		
	echo 'Inserted a new row; resulting id: '.$user_id;
	*/
/*echo '<pre>';
print_r($this->user);
echo '</pre>';
*/
$full_moon = 1326119760;
echo Time::display($full_moon).'<br>';

echo Time::display($full_moon, 'M D Y').'<br>';

echo 'App timezone: '.Time::display($full_moon).'<br>';

echo 'LA timezone: '.Time::display($full_moon, '', 'America/Los_Angeles').'<br>';

echo '<br>User\'s timezone: '.Time::display($full_moon, '', $this->user->timezone).'<br>';
}
} #end of class