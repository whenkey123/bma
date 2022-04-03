<?php
include('db-connect.php');
if (!isLoggedIn()) {
  header('Location: login.php');
  exit();
}
$user = $_SESSION['user'];
if($_SERVER['REQUEST_METHOD']=="POST") {
  if ($_POST['form']=="add") {
    $fingerprint_id=$_POST['fingerprint_id'];
    $roll=strtoupper($_POST['roll']);
    $name=ucwords($_POST['name']);
    $department=$_POST['department'];
    $phone=$_POST['phone'];
    $current_time = time();
    $sql="INSERT INTO `students` (`id`, `roll_number`, `name`, `department`, `phone`, `fingerprint_id`, `added_at`) VALUES (NULL, '$roll', '$name', '$department', '$phone', '$fingerprint_id', '$current_time');";
    if(mysqli_query($con, $sql)) {
      header('Location: students.php?alert=add');
      exit();
    }else {
      header('Location: students.php?alert=exists');
      exit();
    }
  }else if ($_POST['form']=="delete") {
    $id = $_POST['id'];
    $sql = "DELETE FROM students WHERE id='$id'";
    if(mysqli_query($con, $sql)) {
      header('Location: students.php?alert=delete');
      exit();
    }
  }
  header('Location: students.php?alert=error');
  exit();
}
?>

<!doctype html>
<html lang="en">
   <head>
      <title>Students</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <style media="screen">
        .align-right { text-align: right; }
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
                     <a class="nav-link" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="admins.php">Admins</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="students.php">Students</a>
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
        <div class="row <?php echo(($user['id']==1)?'':'d-none'); ?>">
          <div class="col-12 align-right">
            <button class="btn btn-outline-primary pull-right" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
              Add New Student
            </button>
          </div>
          <div class="collapse mt-3" id="collapseExample">
            <div class="card">
              <div class="card-header d-inline">
                Add New Student
              </div>
              <div class="card-body">
                <form class="row g-3" action="" method="POST">
                  <input name="form" value="add" class="d-none">
                  <div class="col-md-2">
                    <label class="form-label">Finger Print Id</label>
                    <input type="number" class="form-control" name="fingerprint_id" placeholder="Finger Print Id" min="1" max="1000" required>
                  </div>
                  <div class="col-md-2">
                    <label class="form-label">Roll Number</label>
                    <input type="text" class="form-control" name="roll" placeholder="Roll Number" minlength="10" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" autocomplete="off" required>
                  </div>
                  <div class="col-md-2">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone" placeholder="Phone Number" minlength="10" maxlength="10" autocomplete="off" onkeypress="return isNumber(event)">
                  </div>
                  <div class="col-md-2">
                    <label class="form-label">Department</label>
                    <select class="form-control" name="department" required>
                      <option value="">Select</option>
                      <option value="IT">IT</option>
                      <option value="CSE">CSE</option>
                      <option value="ECE">ECE</option>
                      <option value="EEE">EEE</option>
                      <option value="MECH">MECH</option>
                      <option value="CIVIL">CIVIL</option>
                    </select>
                  </div>
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary">Add</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 mt-4">
            <div class="card">
              <div class="card-header">
                Active Students
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover mb-0">
                    <thead>
                      <tr>
                        <th scope="col">Finger Print Id</th>
                        <th scope="col">Roll Number</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Department</th>
                        <th scope="col">Added At</th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $query=mysqli_query($con, "SELECT * FROM students;");
                      while($row = mysqli_fetch_array($query)) {
                        $delete_html = '';
                        if ($user['id']==1) {
                          $delete_html = '<form style="display: inline;" action="" method="POST">
                          <input name="form" value="delete" class="d-none">
                          <input name="id" value="'.$row['id'].'" class="d-none">
                          <button class="btn btn-sm btn-outline-danger">Delete</button>
                          </form>';
                        }
                        echo('<tr>
                          <th scope="row">'.$row['fingerprint_id'].'</th>
                          <td>'.$row['roll_number'].'</td>
                          <td>'.$row['name'].'</td>
                          <td>'.$row['phone'].'</td>
                          <td>'.$row['department'].'</td>
                          <td>'.date('d/m/Y h:i A', $row['added_at']).'</td>
                          <td class="align-right">'.$delete_html.'</td>
                        </tr>');
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
      <script src="./js/common.js"></script>
      <script type="text/javascript">
        var alert_key = findGetParameter('alert')
        if (alert_key) {
          if (alert_key == "add") {
            confirm('New Student added successfully');
            window.location.href = 'students.php';
          }else if (alert_key == "delete") {
            confirm('Student deleted successfully');
            window.location.href = 'students.php';
          }else if (alert_key == "exists") {
            confirm('Student already exists with the same Roll number or Finger print id');
            window.location.href = 'students.php';
          }else if (alert_key == "error") {
            confirm('Error while performing action');
            window.location.href = 'students.php';
          }
        }
      </script>
   </body>
</html>
