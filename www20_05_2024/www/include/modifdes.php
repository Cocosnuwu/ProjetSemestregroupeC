<?php
        session_start();

        // Inclure le fichier de base de données
        include 'database.php';

        // Récupérer l'ID de l'utilisateur connecté depuis la session
        $user_id = $_SESSION['user']['id'];

        // Informations de l'utilisateur (à remplacer par les données de la base de données)
        $query = $db->prepare("SELECT des FROM utilisateur WHERE id = :user_id");
        $query->execute(array(':user_id' => $user_id));
        $user = $query->fetch();
        $des = $user['des'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Rencontre Prof</title>
    <link rel="stylesheet" href="../css/modifdes.css">
    
</head>
<body>
    <div class="container">
        
    <?php
        // Affichage du profil
        echo '<h1> Ma description </h1>';

        // Formulaire pour la description, les activités favorites et les GIFs
        echo '<form action="" method="post" enctype="multipart/form-data">';
        echo '<label for="description"></label><br>';
        echo '<textarea name="description" rows="4" cols="50">' . $des . '</textarea><br>';
        
        // Bouton pour sortir de la personnalisation
        echo '<input type="submit" name="submit" value="Enregistrer">';
        echo '</form>';

        // Vérifiez si le formulaire a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
            // Récupérer la description de l'utilisateur
            $des = isset($_POST['description']) ? $_POST['description'] : '';

            // Insérer les données dans la base de données
            $query = $db->prepare("UPDATE utilisateur SET des = :des WHERE id = :user_id");
            $query->execute(array(
                ':user_id' => $user_id,
                ':des' => $des,
            ));
        }

        // Bouton pour quitter la personnalisation
        echo '<form action="../profile.php" method="get">';
        echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
        echo '<input type="submit" value="Quitter">';
        echo '</form>';
        ?>
    </div>
</body>
</html>
