<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>iRL Login</title>
    <link rel="stylesheet" type="text/css" href="css/screen.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, scale-to-fit=no">
  </head>
  <body class="citybackground">
  <?php 

    include "login.php";
    //$username="scarpen3";
    include "connect.php";
    include "nav.php";
  $sql = "SELECT * FROM user_table WHERE username='$username'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();
  $num = $result->num_rows;
  if($num == '0'){
      header("Location: signup.php");
  } else {
  }
  ?>

<div id="appwrapper">
  <div class="header">
    <img src="images/logo.png" />
 	 </div>
      <form method="post">
        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="<?php echo $row['name']?>">
        <label for="phone">Phone</label>
        <input id="phone" type="text" name="phone" value="<?php echo $row['phone']?>"> 
        <label for="facebook">Facebook</label>
        <input id="facebook" type="text" name="facebook" value="<?php echo $row['facebook']?>"> 
        <label for="twitter">Twitter</label>
        <input id="twitter" type="text" name="twitter" value="<?php echo $row['twitter']?>">
        <label for="email">Email</label>
        <input id="email" type="text" name="email" value="<?php echo $row['email']?>">
        <input type="submit" value="Save Settings" name="submitbutton">
					</form> 
        
        <?php
        
				$sql = "SELECT * FROM admins WHERE username='$username'";
        $result = $mysqli->query($sql);
        $num = $result->num_rows;
               
        if($num == '0'){
          //the logged in user isn't in the admin database
        } 
        else {
										//user is an admin
									
										echo "<div id='admintools'><h1>Administrator Tools</h1>";
									//***********Make users into admins
										$sql = "SELECT username FROM user_table";
          $result = $mysqli->query($sql);
									
										echo "<form method='post'>";
          echo "<select name='adminselect'>";
          
          while($row = $result->fetch_assoc()) {
            echo "<option>" . $row["username"] . "</option>";
          }
          
          echo "<input type='submit' value='Make Admin' name='adminsubmitbutton'>";
										echo "</form>";
									
										//***********Take admin privileges away from an admin
										$sql = "SELECT username FROM admins";
          $result = $mysqli->query($sql);
									
										echo "<form method='post'>";
          echo "<select name='deleteadminselect'>";
          
          while($row = $result->fetch_assoc()) {
            echo "<option>" . $row["username"] . "</option>";
          }
          
          echo "<input type='submit' value='Remove Admin' name='deleteadminsubmitbutton'>";
										echo "</form>";
											
										//********************Reset a users time
										$sql = "SELECT username FROM user_table";
          $result = $mysqli->query($sql);
									
										echo "<form method='post'>";
          echo "<select name='resettimeselect'>";
          
          while($row = $result->fetch_assoc()) {
            echo "<option>" . $row["username"] . "</option>";
          }
          
          echo "<input type='submit' value='Set time to Zero' name='resettimesubmitbutton'>";
										echo "</form></div>";
          // SQL DUMP
          echo "<form method='post'>";
          echo "<input type='submit' value='DUMP DATA' name='sqlsubmitbutton'>";

            echo "</form>";
        }		
															
         
  //submit button actions 
  if (isset($_POST['sqlsubmitbutton'])){

  $file="irl.sql";
  if (file_exists($file)){
  exec( "rm -r $file ");  
  }
  exec( "mysqldump -u $dbusername --password=$dbpassword irl > $file");
  
  if (file_exists($file))
    {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exec( "rm -r $file ");
    exit;
    }

/*
    $filename = "backup-" . date("d-m-Y") . ".sql";
    header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
    $cmd = "mysqldump -u $dbusername --password=$dbpassword irl";   

    passthru( $cmd );*/

  }         
          if (isset($_POST['adminsubmitbutton'])){
											
            	$adminselected = $_POST['adminselect'];
													$sql = "SELECT * FROM admins WHERE username='$adminselected'";
													$result = $mysqli->query($sql);
													$num = $result->num_rows;
               
														if($num > 0){
																//the admin is already an admin
														} 
													else {

														$sql = "INSERT INTO admins VALUES('admin', '$adminselected')";

														$result = $mysqli->query($sql);

														if ($mysqli->error) {
																echo $mysqli->error;
																$message="Unable to update!";		      
																echo "<script type='text/javascript'>alert('$message');</script>";
														} else {
																$message="Update Succesful!";
																echo "<script type='text/javascript'>alert('$message');</script>";
																header("Refresh:0; url=settings.php");
														}
													}
											}
											
										if (isset($_POST['deleteadminsubmitbutton'])){
            $deleteadminselected = $_POST['deleteadminselect'];
          
												$sql = "DELETE FROM admins
												WHERE username = '$deleteadminselected'";

												$result = $mysqli->query($sql);

												if ($mysqli->error) {
														echo $mysqli->error;
														$message="Unable to update!";		      
														echo "<script type='text/javascript'>alert('$message');</script>";
												} else {
														$message="Update Succesful!";
														echo "<script type='text/javascript'>alert('$message');</script>";
														header("Refresh:0; url=settings.php");
												}
										}
										
											if (isset($_POST['resettimesubmitbutton'])){
            $resettimeselected = $_POST['resettimeselect'];
                    $stmt = $mysqli->prepare("UPDATE user_table SET
                                      available= " . (time()/60). 
                                      "WHERE username=?");
                  $stmt->bind_param("s", $resettimeselected);
                  $stmt->execute();

												$result = $mysqli->query($sql);

												if ($mysqli->error) {
														echo $mysqli->error;
														$message="Unable to update!";		      
														echo "<script type='text/javascript'>alert('$message');</script>";
												} else {
														$message="Update Succesful!";
														echo "<script type='text/javascript'>alert('$message');</script>";
														header("Refresh:0; url=settings.php");
												}
										}
        
        ?>
 
      </div> 
      
<?php
               
       
//normal users submit button
      if (isset($_POST['submitbutton'])){
          $name = $_POST['name'];
          $phone = $_POST['phone'];
          $facebook = $_POST['facebook'];
          $twitter = $_POST['twitter'];
          $email = $_POST['email'];
          $stmt = $mysqli->prepare("UPDATE user_table SET
                            name=?,
                            phone=?,
                            facebook=?,
                            twitter=?,
                            email=?
                            WHERE username=?");
            $stmt->bind_param("ssssss", $username, $phone, $facebook, $twitter, $email, $username);
            $stmt->execute(); 
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
</html>