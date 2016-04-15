<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>iRL Login</title>
    <link rel="stylesheet" type="text/css" href="css/screen.css">
  </head>

  <body class="citybackground">
	<?php 
		require_once 'login.php'; 
		include 'nav.php';
	?>
		
		<div class="login">
			<div class="header">
				<p class="iit">Illinois Tech</p>
				iRL
			</div>
		<form action="settings.php" method="post">
		<label for="firstname">First Name</label>
		<input id="firstname" type="text" name="firstname" placeholder="example">
		
		    <label for="phone">Phone</label>
		    <input id="phone" type="text" name="phone" placeholder="123-456-7899"> 
		    <label for="facebook">Facebook</label>
				<input id="facebook" type="text" name="facebook" placeholder="https://facebook.com/superdude"> 
				<label for="twitter">Twitter</label>
				<input id="twitter" type="text" name="twitter" placeholder="https://twitter.com/superdude">
				<label for="email">Email</label>
				<input id="email" type="text" name="email" placeholder="you@website.com">
	
				<input type="submit" value="submit" name="submitbutton">
		</form>
		</div>    
    
  
  </body>
</html>