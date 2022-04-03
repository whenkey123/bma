<?php
include('db-connect.php');
if (isset($_GET['fingerprint_id'])) {
  $fingerprint_id=$_GET['fingerprint_id'];
  $sql = "SELECT * from `students` WHERE `fingerprint_id`='$fingerprint_id';";
  $student_details = mysqli_fetch_array(mysqli_query($con, $sql));
  if (isset($student_details)) {
    $roll_number=$student_details['roll_number'];
    $name=$student_details['name'];
    $phone=$student_details['phone'];
    $department=$student_details['department'];
    $current_time=time();
    $sql="INSERT INTO `student_attendance` (`id`, `roll_number`, `name`, `phone`, `department`, `entry_time`) VALUES (NULL, '$roll_number', '$name', '$phone', '$department', '$current_time');";
    if (mysqli_query($con, $sql)) {
      echo("Attendance Taken");
    }else {
      echo("Attendance Error");
    }
  }else {
    echo("No Student Found");
  }
}
?>
