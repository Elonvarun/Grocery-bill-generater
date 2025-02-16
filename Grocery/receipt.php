<?php
// receipt.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}
if (!isset($_SESSION['bill'])) {
  header("Location: generate_bill.php");
  exit;
}

$bill = $_SESSION['bill'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Bill Receipt - Grocery List & Bill Generator</title>
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
      text-align: center;
      position: relative;
    }
    header h1 {
      margin: 0;
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
    nav ul {
      list-style: none;
      padding: 0;
      text-align: center;
      margin: 10px 0;
    }
    nav ul li {
      display: inline-block;
      margin: 0 10px;
    }
    nav ul li a {
      color: #fff;
      text-decoration: none;
    }
    main {
      padding: 20px;
      width: 90%;
      max-width: 900px;
      margin: 20px auto;
      background: #fff;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    .receipt {
      text-align: center;
    }
    .receipt h2 {
      margin-top: 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 10px;
      text-align: center;
    }
    button {
      background: #5cb85c;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    button:hover {
      background: #4cae4c;
    }
    footer {
      background: #333;
      color: #fff;
      text-align: center;
      padding: 5px 0;  /* Reduced padding */
      position: fixed;
      bottom: 0;
      width: 100%;
      font-size: 12px;  /* Smaller font size */
    }
  </style>
  <script>
    function printBill() {
      window.print();
    }
  </script>
</head>
<body>
  <header>
    <h1>Bill Receipt</h1>
    <div class="logout-box">
      <a href="logout.php">Logout</a>
    </div>
    <nav>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="generate_bill.php">Generate New Bill</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div class="receipt">
      <h2>Grocery Store</h2>
      <p><strong>Bill Number:</strong> <?php echo $bill['bill_number']; ?></p>
      <p><strong>Date & Time:</strong> <?php echo $bill['date_time']; ?></p>
      <table>
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Item Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($bill['items'] as $item): ?>
            <tr>
              <td><?php echo htmlspecialchars($item['product_name']); ?></td>
              <td><?php echo $item['price']; ?></td>
              <td><?php echo $item['quantity']; ?></td>
              <td><?php echo $item['item_total']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <h3>Total Amount: <?php echo $bill['total_amount']; ?></h3>
      <p>Thank You for Shopping with us!</p>
      <p>Store Address: 123, setty Street, Palamaner</p>
    </div>
    <div style="text-align: center;">
      <button onclick="printBill()">Print Bill</button>
      <p>You can also save this bill as PDF using your browser's print options.</p>
    </div>
  </main>
  <footer>
    <p>© 2025 Developed by Varun</p>
    <p>Web Developer & Content Creator</p>
  </footer>
</body>
</html>
