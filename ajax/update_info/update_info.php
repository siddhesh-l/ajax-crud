<?php

//Include Database connection
include_once "../database/db.php";

//Start the session
session_start();

if(!isset($_SESSION['id'])){
   header("location: http://localhost/siddhesh/ajax/login/login.html");
   exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
   //Validate and sanetize the 
}

?>