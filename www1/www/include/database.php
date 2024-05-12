<?php

define('HOST','localhost');
define('DB_NAME','id22077870_siteweb');
define('USER','id22077870_bluteaucor');
define('PASS','Rencontreprof2024*');

try {
    $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    // Arrêter le script ou gérer l'erreur d'une autre manière si nécessaire
}
