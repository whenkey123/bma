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
    $status='intime';
    $final_intime = DateTime::createFromFormat('m/d/Y H:i:s', date("m/d/Y").' 10:30:00')->getTimestamp();
    if ($current_time > $final_intime) {
      $status='late';
    }
    $sql="INSERT INTO `student_attendance` (`id`, `roll_number`, `name`, `phone`, `department`, `entry_time`, `status`) VALUES (NULL, '$roll_number', '$name', '$phone', '$department', '$current_time', '$status');";
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
