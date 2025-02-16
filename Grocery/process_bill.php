<?php
// process_bill.php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
  header("Location: login.php");
  exit;
}
require 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['items'])){
    $selectedItems = $_POST['items'];
    $quantities = $_POST['quantities'];

    $billItems = array();
    $totalAmount = 0;

    foreach($selectedItems as $itemId){
        $stmt = $conn->prepare("SELECT * FROM grocery_items WHERE id=?");
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1){
            $item = $result->fetch_assoc();
            // Use entered quantity or default to 1
            $qty = isset($quantities[$itemId]) ? (int)$quantities[$itemId] : 1;
            $itemTotal = $item['price'] * $qty;
            $totalAmount += $itemTotal;
            $billItems[] = array(
                'product_name' => $item['product_name'],
                'price' => $item['price'],
                'quantity' => $qty,
                'item_total' => $itemTotal
            );
        }
        $stmt->close();
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
