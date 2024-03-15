<?php // login.php
$host = 'fasttravel.loc'; 
$data = 'fast_travel'; 
$user = 'journal_administrator'; 
$pass = 'sjrfg8VI8130'; 
$chrs = 'utf8mb4';
$attr = "mysql:host=$host;dbname=$data;charset=$chrs";
$opts =
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];


