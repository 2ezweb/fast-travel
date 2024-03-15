<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/connect.php';

$order_id = $_POST['order_id'];
$discount = $_POST['discount'];
$status = $_POST['status'];

$stmt= $pdo->prepare("UPDATE orders SET discount = ?, payment_status = ? WHERE order_id ='$order_id'");
$stmt->execute([$discount, $status]);

redirect();
