<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>iRL Login</title>
    <link rel="stylesheet" type="text/css" href="css/screen.css">
  </head>
  <body class="citybackground">
  <?php 

  include "login.php";
  include "connect.php";
		$username=phpCAS::getUser();
		?>
  <p>****Please Sign up****</p>
  <p>****Use Hawk Information****</p>

  <div class="login">
			<div class="header">
				<p class="iit">Illinois Tech</p>
				iRL
			</div>
		<form method="post">
		<label for="firstname">First Name</label>
		<input id="firstname" type="text" name="firstname" placeholder="John">
		<label for="lastname">Last Name</label>
		<input id="lastname" type="text" name="lastname" placeholder="Doe">

		
		    <label for="phone">Phone</label>
		    <input id="phone" type="text" name="phone" placeholder="(123) 456-7899"> 
		    <label for="facebook">Facebook</label>
				<input id="facebook" type="text" name="facebook" placeholder="https://facebook.com/superdude"> 
				<label for="twitter">Twitter</label>
				<input id="twitter" type="text" name="twitter" placeholder="https://twitter.com/superdude">
				<label for="email">Email</label>
				<input id="email" type="text" name="email" placeholder="you@something.com">
	
				<input type="submit" value="submit" name="submitbutton">
		</form>
		</div> 
		<?php
		if (isset($_POST['submitbutton'])){
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
  			$phone = $_POST['phone'];
  			$facebook = $_POST['facebook'];
  			$twitter = $_POST['twitter'];
  			$email = $_POST['email'];
  			$name=$firstname." ".$lastname;

  			$sql = "INSERT INTO user_table (`username`, `name`, `phone`, `facebook`, `email`, `twitter`) VALUES ('$username','$name','$phone','$facebook','$email','$twitter')";

		      $result = $mysqli->query($sql);

			  if ($mysqli->error) {
			      echo $mysqli->error;
			      $message="Unable to update!";		      
			echo "<script type='text/javascript'>alert('$message');</script>";
			  } else {
			  	$message="Update Succesful!";
			    echo "<script type='text/javascript'>alert('$message');</script>";
			  	header("Refresh:0; url=main.php");
			  }
			$mysqli->close();
			
    	}?>

  </body>