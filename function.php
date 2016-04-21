<?php
  include 'connect.php';
  require_once 'login.php'; 
  $username=phpCAS::getUser();

  $sql = "SELECT * FROM user_table WHERE username='$username'";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();

  $servertoken = "";
  $clienttoken = "";
  //The function below should be run once we have authenticated the user via CAS.
  function generatetoken() {
    $raw = "";
    $servertoken = hash('sha256', $raw);
    $clienttoken = hash('ripemd160', $servertoken);
    $experation = (time()+3600); //expire in 1 hour
    setcookie("rltoken", $clienttoken, $experation);
    //Please store $servertoken in the database token field.
    //Please store $experation in the database experation field.
    $sql = "UPDATE user_table SET
            token='$servertoken',
            expire='$experation'
            WHERE username='$username'";
    $result = $mysqli->query($sql);
  if ($mysqli->error) {
      echo $mysqli->error;
  }
  }
  
  //Use the function below to see if user is already authenticated.  Will return true if they are or false if they aren't.
  function validatetoken() {
    //Please read the experation and servertoken fields into the vars below.
    $experation = $row["expire"];
    $servertoken = $row["token"];
    echo $experation.$servertoken;
    //Don't touch below.
    $authed = false;
    if (!($experation < time())) {
      if(isset($_COOKIE["rltoken"])) {
        $clienttoken = $_COOKIE["rltoken"];
        if ($clienttoken == hash('ripemd160', $servertoken)) {
          $authed = true;
        }
      }
    }
    return authed;
  }
?>