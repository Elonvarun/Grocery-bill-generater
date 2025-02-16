<?php
// dashboard.php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Grocery List & Bill Generator</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    header {
      background: #333;
      color: #fff;
      padding: 10px 0;
      position: relative;
    }
    header h1 {
      margin: 0;
      text-align: center;
      font-size: 28px;
    }
    .logout-box {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      background: #555;
      padding: 8px 12px;
      border-radius: 5px;
    }
    .logout-box a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
    }
    .nav-boxes {
      display: flex;
      justify-content: center;
      margin: 30px 0;
    }
    .nav-box {
      background: #fff;
      border: 1px solid #ddd;
      padding: 20px;
      margin: 0 10px;
      border-radius: 5px;
      text-align: center;
      width: 220px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    .nav-box a {
      text-decoration: none;
      color: #333;
      font-weight: bold;
      display: block;
    }
    .welcome {
      text-align: center;
      margin-top: 50px;
      font-size: 24px;
      color: #333;
    }
    footer {
      background: #333;
      color: #fff;
      text-align: center;
      padding: 10px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
</head>
<body>
  <header>
    <h1>Admin Dashboard</h1>
    <div class="logout-box">
      <a href="logout.php">Logout</a>
    </div>
  </header>
  
  <div class="nav-boxes">
    <div class="nav-box">
      <a href="manage_items.php">Manage Grocery Items</a>
    </div>
    <div class="nav-box">
      <a href="generate_bill.php">Generate Grocery Bill</a>
    </div>
  </div>
  
  <div class="welcome">
    <p>Welcome, Admin!</p>
  </div>
  
  <footer>
    <p>© 2025 Developed by Varun - Web Developer & Content Creator</p>
  </footer>
</body>
</html>
