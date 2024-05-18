<?php
session_start();

// Inclure le fichier de base de données
include 'include/database.php';

// Récupérer l'ID de l'utilisateur connecté depuis la session
$user_id = $_SESSION['user']['id'];



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
    <style>
        /* Ajoutez vos styles CSS personnalisés ici */
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .back-arrow {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 24px;
            color: #555555;
        }
        .view-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            
        }
        .logo {
            margin-top: 50px;
            display: flex;
            justify-content: center;
        }
        .logo img {
            width: 800px; /* Ajustez la taille du logo selon vos besoins */
            max-width: 100%;
            right: 50%;
        }
        .description {
            margin-top: 20px;
            color: #555555;
        }
        .actions {
            margin-top: 50px; /* Ajustez la marge supérieure selon vos besoins */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }
        .action-button {
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            
            
        }
        .action-button img {
            width: 20px;
            margin-right: 50px;
            
        }

        /* Media queries pour les appareils mobiles */
        @media only screen and (max-width: 600px) {
            .back-arrow,
            .view-button {
                position: static;
                display: block;
                margin: 10px auto;
            }
            .logo {
                margin-top: 20px;
            }
            .actions {
                margin-top: 20px;
            }
        }
    </style>
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
        <a href="include/modifphoto.php?user_id=<?php echo $user_id; ?>" class="action-button">
            <img src="http://www.clipartbest.com/cliparts/9i4/edX/9i4edX7GT.png" alt="Camera Icon">
            Photos
        </a>
        <a href="include/modifdes.php?user_id=<?php echo $user_id; ?>" class="action-button">
            <img src="https://icon-library.com/images/book-icon-png/book-icon-png-26.jpg" alt="Book Icon">
            Description
        </a>
        <a href="include/modifpass.php?user_id=<?php echo $user_id; ?>" class="action-button">
            <img src="https://static.thenounproject.com/png/1178599-200.png" alt="Heart Icon">
            Passion
        </a>
        <a href="include/modifgif.php?user_id=<?php echo $user_id; ?>" class="action-button">
            <img src="https://www.pngmart.com/files/1/Video-Icon-PNG-Free-Download.png" alt="Triangle Icon">
            GIFs
        </a>
    </div>
        
        
        
        
</body>
</html>

