<?php
// Inclure le fichier de base de données
include 'include/database.php';

// Vérifier si l'ID de l'utilisateur est passé en paramètre dans l'URL
if (isset($_GET['user_id'])) {
    // Récupérer l'ID de l'utilisateur depuis l'URL
    $user_id = $_GET['user_id'];

    // Sélectionner les informations de l'utilisateur à partir de la base de données
    $query = $db->prepare("SELECT * FROM utilisateur WHERE id = :user_id");
    $query->execute(array(':user_id' => $user_id));
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur existe dans la base de données
    if ($user) {
        // Afficher les informations de l'utilisateur
        echo '<h1>Profil de ' . $user['Prenom'] . ' ' . $user['Nom'] . '</h1>';
        echo '<p>Age : ' . $user['age'] . '</p>';
        echo '<p>Description : ' . $user['des'] . '</p>';
        // Vous pouvez ajouter ici d'autres informations à afficher, comme les activités favorites, les GIFs préférés, etc.
    } else {
        echo "L'utilisateur avec l'ID spécifié n'existe pas.";
    }
} else {
    echo "Aucun ID d'utilisateur spécifié.";
}
?>
