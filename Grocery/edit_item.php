<?php
// edit_item.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: login.php");
  exit;
}
require 'db.php';

if (!isset($_GET['id'])) {
  header("Location: manage_items.php");
  exit;
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $product_name = $_POST['product_name'];
  $price = floatval($_POST['price']);  // Convert to float
  $quantity = $_POST['quantity'];
  $brand_name = $_POST['brand_name'];

  // Using "sdssi": s = product_name (string), d = price (double), s = quantity (string), s = brand_name (string), i = id (integer)
  $stmt = $conn->prepare("UPDATE grocery_items SET product_name=?, price=?, quantity=?, brand_name=? WHERE id=?");
  $stmt->bind_param("sdssi", $product_name, $price, $quantity, $brand_name, $id);

  if ($stmt->execute()) {
    header("Location: manage_items.php");
    exit;
  } else {
    $error = "Error: " . $stmt->error;
  }
  $stmt->close();
}

// Fetch existing data for the item
$stmt = $conn->prepare("SELECT * FROM grocery_items WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows != 1) {
  header("Location: manage_items.php");
  exit;
}
$item = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Grocery Item - Grocery List & Bill Generator</title>
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
      margin: 10px 0;
      text-align: center;
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
      width: 90%;
      max-width: 600px;
      margin: 20px auto;
      background: #fff;
      padding: 20px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    form {
      display: flex;
      flex-direction: column;
    }
    form label {
      margin: 10px 0 5px;
    }
    form input {
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      background: #5cb85c;
      color: #fff;
      padding: 10px;
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
      font-size: 14px;
    }
    .error {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>
  <header>
    <h1>Edit Grocery Item</h1>
    <nav>
      <ul>
        <li><a href="manage_items.php">Manage Items</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
    <form method="POST" action="">
      <label for="product_name">Product Name:</label>
      <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($item['product_name']); ?>" required>
      
      <label for="price">Price:</label>
      <input type="number" id="price" name="price" step="0.01" value="<?php echo $item['price']; ?>" required>
      
      <label for="quantity">Quantity:</label>
      <input type="text" id="quantity" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" required>
      
      <label for="brand_name">Brand Name:</label>
      <input type="text" id="brand_name" name="brand_name" value="<?php echo htmlspecialchars($item['brand_name']); ?>" required>
      
      <button type="submit">Update Item</button>
    </form>
  </main>
  <footer>
    <p>© 2025 Developed by Varun</p>
    <p>Web Developer & Content Creator</p>
  </footer>
</body>
</html>
