<?php 

function conectarDB() : mysqli {
    $db = new mysqli(
        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        $_ENV['BD_BD'],
        
    );


    if(!$db) {
        echo 'Error no se pudo conectar';
        exit;
    }
    
    return $db;

}

