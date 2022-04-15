<?php
date_default_timezone_set("Asia/Kolkata");
session_start();
$con = mysqli_connect("localhost", "root", "", "bma") or die("Unable to connect");
$alert_error="";
function isLoggedIn() {
  return(isset($_SESSION["user"]));
}
function displayRowColour($entry_type) {
  if ($entry_type == "Early") {
    return "alert-warning";
  }else if($entry_type == "InTime") {
    return "alert-success";
  } else {
    return "alert-danger";
  }
}
?>
