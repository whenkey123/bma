<?php
include("db-connect.php");
if (isLoggedIn()) {
  header("Location: index.php");
  exit();
}
if ($_SERVER["REQUEST_METHOD"]=="POST") {
  $email=$_POST["email"];
  $password=$_POST["password"];
  $sql="SELECT * FROM admins WHERE email='$email' AND password='$password';";
  $user=mysqli_fetch_array(mysqli_query($con, $sql), MYSQLI_ASSOC);
  if(isset($user)) {
    $_SESSION['user']=$user;
    header('Location: index.php');
    exit();
  }
  $alert_error="Invalid Email Address or Password";
}
?>
<!doctype html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Custom styles for this template -->
  <link href="css/signin.css" rel="stylesheet">
</head>
<body class="text-center">
  <main class="form-signin">
    <form action="" method="POST">
      <img class="mb-4" src="https://via.placeholder.com/100x100.png?text=LOGO" alt="" width="100" height="100">
      <h1 class="h3 mb-3 fw-normal">IoT Biometric Admin</h1>
      <div class="form-floating">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="whenkey123@gmail.com" required>
        <label for="email">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="password@123" required>
        <label for="password">Password</label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    </form>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script type="text/javascript">
    <?php
    echo(($alert_error!="")?'alert("'.$alert_error.'");':'');
    ?>

  </script>
</body>
</html>
