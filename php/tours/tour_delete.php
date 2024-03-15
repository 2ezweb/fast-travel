<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/connect.php';

    $tour_id = $_POST['tour_id'];

    $stmt = $pdo->prepare("DELETE FROM tours WHERE tour_id='$tour_id'");
    $stmt->execute();

    redirect();