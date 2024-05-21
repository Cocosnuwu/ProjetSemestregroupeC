<?php
session_start();

// Inclure le fichier de base de données
include '../include/database.php';

// Variable de message d'erreur/succès
$message = '';

// Vérifier si le formulaire de suppression a été soumis
if (isset($_POST['delete_user'])) {
    // Vérifier si l'ID de l'utilisateur à supprimer a été envoyé
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        
        // Supprimer l'utilisateur de la base de données
        $delete_query = $db->prepare("DELETE FROM utilisateur WHERE id = :id");
        $delete_query->execute(array(':id' => $user_id));

        // Afficher un message de succès
        $message = "L'utilisateur a été supprimé avec succès.";
    } else {
        $message = "ID d'utilisateur manquant.";
    }
}

// Fonction pour afficher la liste des utilisateurs
function displayUserList($db) {
    $output = '';

    // Récupérer tous les utilisateurs de la base de données
    $query = $db->query("SELECT * FROM utilisateur");
    $users = $query->fetchAll(PDO::FETCH_ASSOC);

    // Afficher la liste des utilisateurs sous forme de tableau
    if ($users) {
        $output .= "<table border='1'>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Action</th>
                        </tr>";

        foreach ($users as $user) {
            $output .= "<tr>
                            <td>{$user['id']}</td>
                            <td>{$user['Nom']}</td>
                            <td>{$user['Prenom']}</td>
                            <td>
                                <form method='post' onsubmit='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\");'>
                                    <input type='hidden' name='user_id' value='{$user['id']}'>
                                    <input type='submit' name='delete_user' value='Supprimer'>
                                </form>
                            </td>
                        </tr>";
        }

        $output .= "</table>";
    } else {
        $output = "Aucun utilisateur trouvé.";
    }

    return $output;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Admin</title>
    <link rel="stylesheet" type="text/css" href="../css/suppressionadmin.css">
</head>
<body>
    <div class="container">
        <h1>Gestion Admin</h1>

        <!-- Barre de recherche d'utilisateur -->
        <form method="get">
            <label for="search_user">Rechercher un utilisateur :</label>
            <input type="text" name="search_user" id="search_user">
            <input type="submit" value="Rechercher">
        </form>

        <!-- Affichage de la liste des utilisateurs -->
        <h2>Liste des utilisateurs</h2>
        <?php echo displayUserList($db); ?>

        <!-- Affichage du message d'erreur/succès -->
        <p class="message"><?php echo $message; ?></p>

        <!-- Lien de retour -->
        <a href="../menuabonne.php" class="back-link">&#8592; Retour</a>
    </div>
</body>
</html>
