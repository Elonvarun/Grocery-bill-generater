<?php
// process_bill.php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
  header("Location: login.php");
  exit;
}
require 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['items'])){
    $selectedItems = is_array($_POST['items']) ? $_POST['items'] : [];
    $quantities = isset($_POST['quantities']) && is_array($_POST['quantities']) ? $_POST['quantities'] : [];

    // Sanitize and validate item IDs
    $itemIds = [];
    foreach ($selectedItems as $rawId) {
        $intId = (int)$rawId;
        if ($intId > 0) {
            $itemIds[] = $intId;
        }
    }

    if (empty($itemIds)) {
        header("Location: generate_bill.php");
        exit;
    }

    // Build a single query for all selected items to avoid N+1 queries
    $idList = implode(',', $itemIds); // Safe because they are integers
    $sql = "SELECT id, product_name, price FROM grocery_items WHERE id IN ($idList)";
    $result = $conn->query($sql);

    $billItems = array();
    $totalAmount = 0.0;

    if ($result && $result->num_rows > 0) {
        while ($item = $result->fetch_assoc()) {
            $id = (int)$item['id'];
            // Use entered quantity; enforce integer >= 1 and reasonable max
            $qty = isset($quantities[$id]) ? (int)$quantities[$id] : 1;
            if ($qty < 1) { $qty = 1; }
            if ($qty > 100000) { $qty = 100000; }

            $price = (float)$item['price'];
            $itemTotal = $price * $qty;
            $totalAmount += $itemTotal;
            $billItems[] = array(
                'product_name' => $item['product_name'],
                'price' => $price,
                'quantity' => $qty,
                'item_total' => $itemTotal
            );
        }
    }

    // Generate a bill number using timestamp and random digits
    $billNumber = "BILL" . time() . rand(100,999);
    $dateTime = date("Y-m-d H:i:s");

    // Save bill info to session for the receipt display
    $_SESSION['bill'] = array(
        'bill_number' => $billNumber,
        'date_time' => $dateTime,
        'items' => $billItems,
        'total_amount' => $totalAmount
    );

    header("Location: receipt.php");
    exit;
} else {
    header("Location: generate_bill.php");
    exit;
}
?>
