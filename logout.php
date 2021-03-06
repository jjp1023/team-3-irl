<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>iRL Login</title>
    <link rel="stylesheet" type="text/css" href="css/screen.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, scale-to-fit=no">
  </head>
<?php
	include 'login.php';
	include 'connect.php';
	include 'nav.php';
	$sql = "SELECT * FROM user_table WHERE username='$username'";
  $result = $mysqli->query($sql);
  $num = $result->num_rows;
  if($num == '0'){
      header("Location: signup.php");
  } else {
  }
	?>
  <body class="citybackground">
		
		<div class="login">
			<div class="header">
    <img src="images/logo.png" />
 	 </div>
		<form action="logout.php" method="post">
		<h1>Are you sure you want to logout out of all IIT Website?</h1>
		      <input type="submit" value="Logout" name="submit">
		</form>
			
<?php
	if (isset($_POST['submit'])){
		/****************************
		* When entered, user goes invisiable
		* Clear cookie and session and
		* then CAS Logout
		****************************/	
		$now = (time()/60);
		$stmt = $mysqli->prepare("UPDATE user_table SET
				available='?'
				WHERE username='?'");
		$stmt->bind_param("ss", $now, $username);
		$stmt->execute();


		if ($mysqli->error) {
				echo $mysqli->error;
		}
			
		$mysqli->close();

		//Unsets Session
		$_SESSION = array();

		//Deletes all cookies before loging user out.
	if (isset($_SERVER['HTTP_COOKIE'])) {
	    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
	    foreach($cookies as $cookie) {
	        $parts = explode('=', $cookie);
	        $name = trim($parts[0]);
	        setcookie($name, '', time()-1000);
	        setcookie($name, '', time()-1000, '/');
	    }
	}
		// Finally, destroy the session.
		session_destroy();

		//Log's user out of CAS.
		phpCAS::logout();
	}

?>
			
 </body>
</html>