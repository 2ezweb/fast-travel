<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/login.php';
    try {
        $pdo = new PDO($attr, $user, $pass, $opts);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    function redirect(){
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }

