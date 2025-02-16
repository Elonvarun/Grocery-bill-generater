<?php
// login.php
session_start();
if(isset($_SESSION['admin_logged_in'])){
  header("Location: dashboard.php");
  exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate admin credentials
    if($email == 'admin@gmail.com' && $password == '123'){
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Grocery List & Bill Generator</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Center the login page vertically and horizontally */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 30px;
            border: 1px solid #ddd;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 300px;
        }
        .login-container form {
            margin-top: 20px;
        }
        .login-container label {
            display: block;
            margin-bottom: 5px;
        }
        .login-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container button {
            background-color: #5cb85c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        .error {
            color: red;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
            background: #333;
            color: #fff;
            padding: 10px 0;
        }
    </style>
</head>
<body>
  <div class="login-container">
    <h2>Admin Login</h2>
    <br>
    <?php if($error != '') { echo '<p class="error">'.$error.'</p>'; } ?>
    <form method="POST" action="">
      <label>Email:</label>
      <input type="email" name="email" required>
      <br>
      <label>Password:</label>
      <input type="password" name="password" required>
      <br>
      <button type="submit">Login</button>
    </form>
  </div>
  <footer>
    <p>© 2025 Developed by Varun - Web Developer & Content Creator</p>
  </footer>
</body>
</html>
