<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/connect.php';

    session_start();
    if (!empty($_SESSION['login_status'])) {
        $substmt = $pdo->query("SELECT * FROM banlist WHERE user_id = (SELECT user_id FROM user WHERE login = '" . $_SESSION['username'] . "')");
        if ($substmt->rowCount() == 0) {
            $response = array(
                'error' => false,
            );
        } else {
            $response = array(
                'error' => true,
                'msg' => 'Користувача заблоковано! Ви не можете більше робити замовлення. Зверніться до технічної підтримки! <a href="mailto:support@fasttravel.loc">support@fasttravel.loc</a>',
            );
        }

    } else {
        $response = array(
            'error' => true,
            'msg' => 'Замовлення може зробити тільки зареєстрований користувач, який зайшов до кабінету',
        );
        
    }

    header('Content-Type: application/json');
    echo json_encode($response, JSON_UNESCAPED_UNICODE); // Добавлен параметр JSON_UNESCAPED_UNICODE для корректного отображения кириллических символов  