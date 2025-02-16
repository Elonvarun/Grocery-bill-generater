<?php
// manage_items.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}
require 'db.php';

// Fetch grocery items from the database
$sql = "SELECT * FROM grocery_items";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Manage Grocery Items - Grocery List & Bill Generator</title>
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
    .button {
      background: #5cb85c;
      color: #fff;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 4px;
      display: inline-block;
      margin-top: 20px;
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
    <h1>Manage Grocery Items</h1>
    <nav>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="generate_bill.php">Generate Bill</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Product Name</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Brand Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo htmlspecialchars($row['product_name']); ?></td>
              <td><?php echo $row['price']; ?></td>
              <td><?php echo htmlspecialchars($row['quantity']); ?></td>
              <td><?php echo htmlspecialchars($row['brand_name']); ?></td>
              <td>
                <a href="edit_item.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete_item.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6">No items found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
    <center>
      <a href="add_item.php" class="button">Add New Item</a>
    </center>
  </main>
  <footer>
    <p>© 2025 Developed by Varun</p>
    <p>Web Developer & Content Creator</p>
  </footer>
</body>
</html>
