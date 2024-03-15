<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/connect.php';

    $id_tour = $_POST['tour_id'];
    $name = $_POST['name'];
    $city = $_POST['city'];
    $type = $_POST['type'];
    $hotel = $_POST['hotel'];
    $stars = $_POST['stars'];
    $min_people = $_POST['min_people'];
    $max_people = $_POST['max_people'];
    $price = $_POST['price'];
    if(isset($_POST['hot_tour'])){
        $status = 2;
    }
    else{
        $status = 1;
    }

    $stmt = $pdo -> prepare("UPDATE tours SET name = ?, city = ?, type = ?, hotel = ?, stars = ?, people_min = ?, people_max = ?, price = ?, status = ? WHERE tour_id='$id_tour'");
    $stmt->execute([$name, $city, $type, $hotel, $stars, $min_people, $max_people, $price, $status]);

    redirect();