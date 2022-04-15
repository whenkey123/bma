<?php
include('db-connect.php');
if (isset($_GET['fingerprint_id'])) {
  $fingerprint_id=$_GET['fingerprint_id'];
  $current_time=time();
  $sql = "SELECT * from `students` WHERE `fingerprint_id`='$fingerprint_id';";
  $student_details = mysqli_fetch_array(mysqli_query($con, $sql));
  if (isset($student_details)) { // Check student is mapped to any finger print id
    $roll_number=$student_details['roll_number'];
    $today_start_timestamp = DateTime::createFromFormat('m/d/Y H:i:s', date("m/d/Y").' 00:00:00')->getTimestamp();
    $today_end_timestamp = DateTime::createFromFormat('m/d/Y H:i:s', date("m/d/Y").' 23:59:59')->getTimestamp();
    $sql="SELECT * FROM `student_attendance` WHERE `roll_number`='$roll_number' AND `entry_time` BETWEEN ".$today_start_timestamp." AND ".$today_end_timestamp." LIMIT 1;";
    $student_log = mysqli_fetch_array(mysqli_query($con, $sql));
    if(isset($student_log)) { // check student today's attendance data
      // Data found for today for the student
      if ($student_log['exit_time']=='') { // Check if exit already reported or not
        // update exit time if exit_time in database is empty
        $sql="UPDATE `student_attendance` SET `exit_time` = '$current_time' WHERE `student_attendance`.`id` = ".$student_log["id"];
        if (mysqli_query($con, $sql)) {
          echo($roll_number.",Exit Reported");
        }else {
          echo("Server Error,");
        }
      }else {
        // exit_time is not empty, that means student exit_time already reported
        echo($roll_number.",Already Exited");
      }

    }else {
      // No data found for today, that means student is giving today's entry
      $name=$student_details['name'];
      $phone=$student_details['phone'];
      $department=$student_details['department'];
      $status='InTime';
      $intime_start = DateTime::createFromFormat('m/d/Y H:i:s', date("m/d/Y").' 06:00:00')->getTimestamp();
      $intime_end = DateTime::createFromFormat('m/d/Y H:i:s', date("m/d/Y").' 10:30:00')->getTimestamp();
      if ($current_time < $intime_start) {
        $status='Early';
      }else if ($current_time > $intime_end) {
        $status='Late';
      }
      $sql="INSERT INTO `student_attendance` (`id`, `roll_number`, `name`, `phone`, `department`, `entry_time`, `exit_time`, `status`) VALUES (NULL, '$roll_number', '$name', '$phone', '$department', '$current_time', '', '$status');";
      if (mysqli_query($con, $sql)) {
        echo($roll_number.",".$status." Attendance");
      }else {
        echo("Server Error,");
      }
    }
  }else {
    echo("No Student Found,with your print");
  }
}
?>
