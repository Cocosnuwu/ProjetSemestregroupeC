<?php
// Connexion à la base de données
include 'include/database.php';

// Vérifier si le terme de recherche est présent et non vide
if(isset($_GET['search']) && !empty(trim($_GET['search']))) {
    // Récupération du terme de recherche
    $searchTerm = trim($_GET['search']);
    error_log("Valeur de search avant la requête SQL : " . $searchTerm);

    try {
        // Requête SQL pour rechercher l'utilisateur par nom et prénom
        $query = $db->prepare("SELECT id, prenom, nom FROM utilisateur WHERE CONCAT(prenom, ' ', nom) LIKE :searchTerm OR CONCAT(nom, ' ', prenom) LIKE :searchTerm LIMIT 3");
        $query->execute([':searchTerm' => '%' . $searchTerm . '%']);
        $users = $query->fetchAll(PDO::FETCH_ASSOC);

        // Vérifier si des utilisateurs ont été trouvés
        if ($users) {
            // Renvoyer les résultats au format JSON
            header('Content-Type: application/json');
            echo json_encode($users);
        } else {
            // Aucun utilisateur trouvé, renvoyer un tableau vide
            header('Content-Type: application/json');
            echo json_encode([]); // Renvoyer un tableau JSON vide
        }
    } catch(PDOException $e) {
        // En cas d'erreur de la base de données, renvoyer un message d'erreur
        http_response_code(500); // Définir le code de réponse HTTP sur 500 (Erreur interne du serveur)
        echo json_encode(['error' => 'Erreur de la base de données: ' . $e->getMessage()]);
    }
} else {
    // Si le terme de recherche est manquant ou vide, renvoyer un message d'erreur
    http_response_code(400); // Définir le code de réponse HTTP sur 400 (Requête incorrecte)
    echo json_encode(['error' => 'Le terme de recherche est manquant ou vide']);
}
?>
