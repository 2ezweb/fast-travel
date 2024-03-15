<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/connect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_second = $_POST['password_second'];

    $stmt = $pdo -> query("SELECT login FROM user WHERE login = '$username'");
    $row = $stmt->fetchColumn();
    if($row){
        $response = array(
            'error' => true,
            'msg' => 'Такий користувач вже існує'
        );
    }
    else{
        if($password == $password_second){
            $create = $pdo->prepare('INSERT INTO user VALUES(NULL, ?, ?, NULL, NULL, NULL, NULL, 3)');
            $create->execute([$username, $password]);
            $response = array(
                'error' => false
            );
        }
        else{
            $response = array(
                'error' => true,
                'msg' => 'Паролі не співпадають'
            );
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_UNICODE); // Добавлен параметр JSON_UNESCAPED_UNICODE для корректного отображения кириллических символов
    

?>