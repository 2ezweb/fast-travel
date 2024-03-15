<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/connect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt_login = $pdo -> query("SELECT login FROM user WHERE login = '$username'");
    $stmt_row = $stmt_login->fetchColumn();
    if($stmt_row){
        $substmt = $pdo -> query("SELECT password, role FROM user WHERE login = '$username' AND password = '$password'");
        $substmt_row = $substmt->fetch();
        if($password == $substmt_row['password']){
            session_start();
            $_SESSION['login_status'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $substmt_row['role'];
            $response = array(
                'error' => false,
            );
        }
        else{
            $response = array(
                'error' => true,
                'msg' => 'Неправильно введено пароль',
            );
        }
    }
    else{
        $response = array(
            'error' => true,
            'msg' => 'Такого користувача не існує',
        );
        
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_UNICODE); // Добавлен параметр JSON_UNESCAPED_UNICODE для корректного отображения кириллических символов

    

?>