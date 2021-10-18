<?php
    session_start();
    
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">

  </head>
  <body>

    <div class="login-form">
      <h2 id="login-title">Login</h2>
      <form class="" action="loginRequest.php" method="post">

        <div class="input-box">
          <label for="username">Username</label>
          <input id="username" name= "usernameField" type="text" required>
        </div>

        <div class="input-box">
          <label for="password">Password</label>
          <input id="password" name="passwordField" type="password" required>
        </div>

        <input id="login-button" type="submit" name="" value="Log in">
        <a id="reset-password" href="resetPasswrod.php">Forgot your password?</a>

        <?php
            if (isset($_SESSION['msg']))
            {
                $msg = $_SESSION['msg'];
                echo "<label'>".$msg."</label>" ;
                unset($_SESSION['msg']);
            }
        ?>

      </form>
    </div>
  </body>

</html>
