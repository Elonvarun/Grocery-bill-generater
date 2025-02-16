<?php
// delete_item.php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
  header("Location: login.php");
  exit;
}
if(isset($_GET['id'])){
    require 'db.php';
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM grocery_items WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
header("Location: manage_items.php");
exit;
?>
