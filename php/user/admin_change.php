<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/connect.php';

session_start();
$username = $_SESSION['username'];
$new_username = $_POST['login'];
$password = $_POST['password'];
$mail = $_POST['mail'];

$check_new = $pdo->query("SELECT * FROM user WHERE login='$new_username'");
if($username == $new_username){
    $stmt = $pdo->prepare("UPDATE user SET login = ?, password = ?, mail = ? WHERE login='$username'");
    $stmt->execute([$new_username, $password, $mail]);
    
    $_SESSION['username'] = $new_username;

    $response = array(
        'error' => false,
    );
}
else{
    if($check_new->rowCount() == 0){
        $stmt = $pdo->prepare("UPDATE user SET login = ?, password = ?, mail = ? WHERE login='$username'");
        $stmt->execute([$new_username, $password, $mail]);
        
        $_SESSION['username'] = $new_username;
    
        $response = array(
            'error' => false,
        );
    }
    else{
        $response = array(
            'error' => true,
            'msg' => 'Такий нікнейм вже є, оберіть інший'
        );
    }    
}






header('Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_UNICODE); // Добавлен параметр JSON_UNESCAPED_UNICODE для корректного отображения кириллических символов  

?>
