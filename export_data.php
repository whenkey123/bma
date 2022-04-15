<?php
include('db-connect.php');
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['sql'])) {
  $sql=$_POST['sql'];
  $items = array();
  //Store table records into an array
  $query=mysqli_query($con, $sql);
  while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
      $items[] = $row;
  }
  //Define the filename with current date
  $fileName = "Students-Attendance-Export-" . date('d-m-Y') . ".xls";
  //Set header information to export data in excel format
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment; filename=' . $fileName);
  //Set variable to false for heading
  $heading = false;
  //Add the MySQL table data to excel file
  if (!empty($items)) {
    $count=0;
    foreach ($items as $item) {
      $count++;
      if (!$heading) {
        echo implode("\t", array_keys($item)) . "\n";
        $heading = true;
      }
      $data=array_values($item);
      $data[0]=$count;
      if (isset($data[5])) {
        $data[5]=date('d/m/Y h:i A', $data[5]);
      }
      if (isset($data[6])) {
        $exit_time='Not Reported Yet';
        if ($data[6]!="") {
          $exit_time=date('d/m/Y h:i A', $data[6]);
        }
        $data[6]=$exit_time;
      }
      if (isset($data[5])) {
        $data[7]=$data[7]." Entry";
      }
      echo implode("\t", $data) . "\n";
    }
  }
  exit();
}
?>
