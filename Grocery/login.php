<?php
// login.php
session_start();
if(isset($_SESSION['admin_logged_in'])){
  header("Location: dashboard.php");
  exit;
}

$error = '';

// Basic session-based throttling to mitigate brute force
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (!isset($_SESSION['last_login_attempt'])) {
    $_SESSION['last_login_attempt'] = 0;
}

$lockSeconds = 2; // small delay between attempts

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (time() - $_SESSION['last_login_attempt'] < $lockSeconds) {
        // Artificial delay
        usleep(300000); // 300ms
    }
    $_SESSION['last_login_attempt'] = time();

    $email = isset($_POST['email']) ? trim(strtolower($_POST['email'])) : '';
    $password = isset($_POST['password']) ? (string)$_POST['password'] : '';

    // Stored admin credentials (in real apps, fetch from DB). Password is hashed.
    $storedEmail = getenv('ADMIN_EMAIL') ?: 'admin@gmail.com';
    $storedPasswordHash = getenv('ADMIN_PASSWORD_HASH') ?: password_hash('123', PASSWORD_DEFAULT);

    $emailMatches = hash_equals(hash('sha256', $storedEmail), hash('sha256', $email));
    $passwordMatches = password_verify($password, $storedPasswordHash);

    if($emailMatches && $passwordMatches){
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['login_attempts'] = 0;
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['login_attempts'] += 1;
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
