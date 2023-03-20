<?php

session_start();

// jika sudah login, alihkan ke halaman list
if (isset($_SESSION['user'])) {
	header('Location: home.php');
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Perpustakaan Politeknik Balekambang </title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
  <form method="post" name="form_login" id="form_login" action="proses-login.php" style="margin-top: 120px;">
    <table class="form">
      <tr>
        <td colspan="2">
          <center><img src="images/mly.png">
            <h1>Selamat Datang</h1>
          </center>
        </td>
      </tr>
      <tr>
        <td>Username</td>
        <td>
          <input type="text" name="username" id="username" />
        </td>
      </tr>
      <tr>
        <td>Password</td>
        <td>
          <input type="password" name="password" id="password" />
        </td>
      </tr>
      <tr style="height:5px"></tr>
      <tr>
        <td colspan="2" align="center">
          <input type="submit" name="login" id="login" value="Login" class="btn btn-submit" />
        </td>
      </tr>
    </table>
  </form>
</body>

</html>