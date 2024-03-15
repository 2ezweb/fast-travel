<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/php/connect/connect.php';
    session_start();
    unset($_SESSION['login_status']);
    unset($_SESSION['username']);
    header('Location: ./login.php');
    exit();