<?php
include('db-connect.php');
if (!isLoggedIn()) {
  header('Location: login.php');
  exit();
}
$user=$_SESSION['user'];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if ($_POST['form']=="new") {
    $name=$_POST['name'];
    $email=$_POST['email'];
    $sql = "INSERT INTO admins (`id`, `name`, `email`, `password`) VALUES (NULL, '$name', '$email', 'password@123')";
    if(mysqli_query($con, $sql)) {
      header('Location: admins.php?alert=add');
      exit();
    }
  }else {
    $id = $_POST['id'];
    $sql = "DELETE FROM admins WHERE id='$id'";
    if(mysqli_query($con, $sql)) {
      header('Location: admins.php?alert=delete');
      exit();
    }
  }
  header('Location: admins.php?alert=error');
  exit();
}
?>

<!doctype html>
<html lang="en">
   <head>
      <title>Admins</title>
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
                     <a class="nav-link active" aria-current="page" href="admins.php">Admins</a>
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
        <div class="row justify-content-md-center">
          <div class="col-12 <?php echo(($user['id']==1)?'':'d-none'); ?>">
            <div class="card">
              <div class="card-header">
                Add New Admin
              </div>
              <div class="card-body">
                <form class="row" action="" method="POST">
                  <input type="text" name="form" value="new" class="d-none">
                  <div class="col-lg-5 col-4">
                    <input type="text" class="form-control" name="name" placeholder="Name" minlength="3" required>
                  </div>
                  <div class="col-lg-5 col-4">
                    <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                  </div>
                  <div class="col-lg-2 col-4">
                    <button type="submit" class="btn btn-outline-primary mb-2" style="width: 100%;">Add Admin</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-12 mt-4">
            <div class="card">
              <div class="card-header">
                Admins
              </div>
              <div class="card-body p-0">
                <table class="table table-hover mb-0">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query=mysqli_query($con, "SELECT * FROM admins;");
                    while($row = mysqli_fetch_array($query)) {
                      $delete_html = '';
                      if ($user['id']==1 && $row['id']!=1) {
                        $delete_html = '<form action="" method="POST">
                        <input name="form" value="delete" class="d-none">
                        <input name="id" value="'.$row['id'].'" class="d-none">
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>';
                      }
                      echo('<tr>
                        <th scope="row">'.$row['id'].'</th>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['email'].'</td>
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
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
      <script src="./js/common.js"></script>
      <script type="text/javascript">
        var alert_key = findGetParameter('alert')
        if (alert_key) {
          if (alert_key == "add") {
            confirm('New Admin added successfully');
            window.location.href = 'admins.php';
          }else if (alert_key == "delete") {
            confirm('Admin deleted successfully');
            window.location.href = 'admins.php';
          }else if (alert_key == "error") {
            confirm('Error while performing action');
            window.location.href = 'admins.php';
          }
        }
      </script>
   </body>
</html>
