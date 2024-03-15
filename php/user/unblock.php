<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/connect.php';

$username = $_POST['username'];

$stmt = $pdo->prepare("DELETE FROM banlist WHERE user_id = (SELECT user_id FROM user WHERE login='$username')");
$stmt->execute();

redirect();