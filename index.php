<?php
include('db-connect.php');
if (!isLoggedIn()) {
  header('Location: login.php');
  exit();
}
$user = $_SESSION['user'];
?>

<!doctype html>
<html lang="en">
   <head>
      <title>Home</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
      </div>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   </body>
</html>
