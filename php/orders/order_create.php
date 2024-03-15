<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/connect.php';

    session_start();
    $people_amount = $_POST['people_amount'];
    $tour_id = $_POST['tour_id'];
    
    $stmt = $pdo -> query("SELECT user_id FROM user WHERE login = '" . $_SESSION['username'] ."'");
    $user_id = $stmt->fetchColumn();

    $insert = $pdo -> prepare("INSERT INTO orders VALUES(NULL, ?, ?, 1, NULL, ?)");
    $insert->execute([$user_id, $tour_id, $people_amount]);

    redirect();
    