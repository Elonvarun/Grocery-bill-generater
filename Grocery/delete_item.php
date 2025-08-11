<?php
// delete_item.php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
  header("Location: login.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['csrf_token'], $_SESSION['csrf_token'])) {
    if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        require 'db.php';
        $id = (int)$_POST['id'];
        $stmt = $conn->prepare("DELETE FROM grocery_items WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: manage_items.php");
        exit;
    } else {
        header("Location: manage_items.php?error=csrf");
        exit;
    }
}

header("Location: manage_items.php");
exit;
?>
