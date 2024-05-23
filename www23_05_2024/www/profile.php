<?php
session_start();

// Inclure le fichier de base de données
include 'include/database.php';

// Récupérer l'ID de l'utilisateur connecté depuis la session
$user_id = $_SESSION['user']['id'];

// Récupérer l'ID de la page consultée
        $page_id = $_GET['user_id'];

// Initialise la variable $peut_personnaliser
$peut_personnaliser = true; // Par défaut, l'utilisateur peut personnaliser

// Définir le chemin vers le dossier des GIFs
$gif_dir = 'gif/';

// Obtenez la liste des fichiers GIF dans le dossier
$gifFiles = glob($gif_dir . '*.gif');
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Rencontre Prof</title>
    <link rel="stylesheet" type="text/css" href="css/profil.css">
    <link rel="stylesheet" type="text/css" href="css/profile2.css">
    
</head>
<body>
    <!-- Flèche retour en arrière -->
    <a href="menuabonne.php" class="back-arrow">&#8592; Retour</a>

    <!-- Bouton "Voir" -->
    <a href="voir.php?user_id=<?php echo $user_id; ?>" class="view-button">Voir</a>
   
    <!-- Logo -->
    <div class="logo">
        <img src="imgweb/logo7.JPG" alt="RencontreProf Logo">
    </div>

    <!-- Texte de bienvenue -->
    <div class="actions">
        <a href="include/modifphoto.php?user_id=<?php echo $page_id; ?>" class="action-button">
            <img src="http://www.clipartbest.com/cliparts/9i4/edX/9i4edX7GT.png" alt="Camera Icon">
            Photos
        </a>
        <a href="include/modifdes.php?user_id=<?php echo $page_id; ?>" class="action-button">
            <img src="https://icon-library.com/images/book-icon-png/book-icon-png-26.jpg" alt="Book Icon">
            Description
        </a>
        <a href="include/modifpass.php?user_id=<?php echo $page_id; ?>" class="action-button">
            <img src="https://static.thenounproject.com/png/1178599-200.png" alt="Heart Icon">
            Passion
        </a>
        <a href="include/modifgif.php?user_id=<?php echo $page_id; ?>" class="action-button">
            <img src="https://www.pngmart.com/files/1/Video-Icon-PNG-Free-Download.png" alt="Triangle Icon">
            GIFs
        </a>
    </div>
        
        
        
        
</body>
</html>

