<?php
// generate_bill.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}
require 'db.php';

$sql = "SELECT * FROM grocery_items";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Generate Grocery Bill - Grocery List & Bill Generator</title>
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
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
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
      padding: 10px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
  <script>
    function toggleQuantity(checkbox, id) {
      var qtyInput = document.getElementById('qty_' + id);
      qtyInput.disabled = !checkbox.checked;
    }
  </script>
</head>
<body>
  <header>
    <h1>Generate Grocery Bill</h1>
    <div class="logout-box">
      <a href="logout.php">Logout</a>
    </div>
    <nav>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="manage_items.php">Manage Items</a></li>
      </ul>
    </nav>
  </header>
  
  <main>
    <form method="POST" action="process_bill.php">
      <table>
        <thead>
          <tr>
            <th>Select</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Default Quantity</th>
            <th>Enter Quantity</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td>
                  <input type="checkbox" name="items[]" value="<?php echo $row['id']; ?>" onchange="toggleQuantity(this, <?php echo $row['id']; ?>)">
                </td>
                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                <td>
                  <input type="number" name="quantities[<?php echo $row['id']; ?>]" id="qty_<?php echo $row['id']; ?>" value="1" min="1" disabled>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5">No items found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      <div style="text-align: center;">
        <button type="submit">Generate Bill</button>
      </div>
    </form>
  </main>
  
  <footer>
    <p>© 2025 Developed by Varun</p>
    <p>Web Developer & Content Creator</p>
  </footer>
</body>
</html>
