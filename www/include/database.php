<?php

define('HOST','localhost');
define('DB_NAME','siteweb');
define('USER','root');
define('PASS','');

try {
    $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    // Arrêter le script ou gérer l'erreur d'une autre manière si nécessaire
}
