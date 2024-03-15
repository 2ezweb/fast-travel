<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/connect.php';

    $username = $_POST['username'];
    
    $stmt = $pdo -> query("SELECT login, mail, phone FROM user WHERE login='$username'");
    $row = $stmt->fetch();
    if(empty($row['login'])){
        $response = array(
            'error' => true,
            'msg' => 'Такого користувача не існує'
        );
    }
    else{
        if(!empty($row['mail'])){
            $response = array(
                'error' => false,
                'msg' => 'На пошту надіслано посилання на сторінку відновлення'
            );
        }
        elseif(!empty($row['phone'])){
            $response = array(
                'error' => false,
                'msg' => 'На телефон було надіслано посилання на сторінку відновлення'
            ); 
        }
        else{
            $response = array(
                'error' => true,
                'msg' => 'В користувача не вказані пошта та номер телефону, тому зверніться в підтримку за адресою <a href="mailto:support@fasttravel.loc">support@fasttravel.loc</a>'
            );
        }    
    }
    
    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_UNICODE); // Добавлен параметр JSON_UNESCAPED_UNICODE для корректного отображения кириллических символов  

?>