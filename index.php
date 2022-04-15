<?php
include('db-connect.php');
if (!isLoggedIn()) {
  header('Location: login.php');
  exit();
}
$user = $_SESSION['user'];
$start_timestamp=DateTime::createFromFormat('m/d/Y H:i:s', date("m/d/Y").' 00:00:00')->getTimestamp();
$end_timestamp=$start_timestamp+86399;
$filter_query="";
if ($_SERVER['REQUEST_METHOD']=="POST") {
  $dates=explode(" - ", $_POST["dates"]);
  $start_timestamp = DateTime::createFromFormat('m/d/Y H:i:s', $dates[0].' 00:00:00')->getTimestamp();
  $end_timestamp = DateTime::createFromFormat('m/d/Y H:i:s', $dates[1].' 23:59:59')->getTimestamp();
}
$filter_query="WHERE `entry_time` BETWEEN ".$start_timestamp." AND ".$end_timestamp;
if (isset($_POST['department']) and $_POST['department']!="ALL") {
  $department=$_POST['department'];
  $filter_query=$filter_query." AND `department`='$department'";
}
if (isset($_POST['entry_type']) and $_POST['entry_type']!="ALL") {
  $entry_type=$_POST['entry_type'];
  $filter_query=$filter_query." AND `status`='$entry_type'";
}

?>

<!doctype html>
<html lang="en">
   <head>
      <title>Home</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
      <style media="screen">
      </style>
   </head>
   <body>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
         <div class="container-fluid">
            <a class="navbar-brand" href="index.php">BMA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
               <ul class="navbar-nav me-auto mb-2 mb-md-0">
                  <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="admins.php">Admins</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="students.php">Students</a>
                  </li>
               </ul>
               <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                     <a class="nav-link" href="profile.php">Profile</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="logout.php">Logout</a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <div class="container" style="margin-top: 100px;">
        <div class="alert alert-primary">
          <marquee>Welcome <?php echo($user['name']); ?> to VSM IoT based attendance management system</marquee>
        </div>
        <form class="row g-3" action="" method="POST">
          <div class="col-lg-3 col-md-4 col-6">
            <label class="form-label">Date Range</label>
            <input type="text" class="form-control" name="dates" required>
          </div>
          <div class="col-lg-3 col-md-3 col-3">
            <label class="form-label">Department</label>
            <select class="form-control" name="department" required>
              <option value="ALL">ALL</option>
              <option value="IT">IT</option>
              <option value="CSE">CSE</option>
              <option value="ECE">ECE</option>
              <option value="EEE">EEE</option>
              <option value="MECH">MECH</option>
              <option value="CIVIL">CIVIL</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-3 col-3">
            <label class="form-label">Entry</label>
            <select class="form-control" name="entry_type" required>
              <option value="ALL">All</option>
              <option value="Early">Early Entry</option>
              <option value="InTime">InTime Entry</option>
              <option value="Late">Late Entry</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-2 mt-5">
            <button type="submit" class="btn btn-outline-primary w-100">Search</button>
          </div>
        </form>
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table w-100 mb-0">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Roll Number</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Phone</th>
                        <th>Entry Time</th>
                        <th>Exit Time</th>
                        <th>Entry Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql="SELECT * FROM `student_attendance` ".$filter_query." ORDER BY `student_attendance`.`id` DESC;";
                      $query=mysqli_query($con, $sql);
                      $i=0;
                      while($row=mysqli_fetch_array($query)) {
                        $i++;
                        $entry_time=date('d/m/Y h:i A', $row['entry_time']);
                        $exit_time='Not Reported Yet';
                        if (isset($row['exit_time']) && $row['exit_time']!="") {
                          $exit_time=date('d/m/Y h:i A', $row['exit_time']);
                        }
                        echo('<tr class="'.displayRowColour($row['status']).'">
                        <td>'.$i.'</td>
                        <td>'.$row['roll_number'].'</td>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['department'].'</td>
                        <td>'.$row['phone'].'</td>
                        <td>'.$entry_time.'</td>
                        <td>'.$exit_time.'</td>
                        <td>'.$row['status'].' Entry</td>
                        </tr>');
                      }
                      if($i==0) {
                        echo('<tr class="alert-primary text-center"><td colspan="8">No Details Found</td></tr>');
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
      <script type="text/javascript">
        $('input[name="dates"]').daterangepicker();
      </script>
   </body>
</html>
