<?php
// Connexion à la base de données
include 'include/database.php';

// Vérifier si le terme de recherche est présent et non vide
if(isset($_GET['search']) && !empty(trim($_GET['search']))) {
    // Récupération du terme de recherche
    $searchTerm = trim($_GET['search']);
    // Récupération des filtres s'ils sont définis
    $activityFilter = isset($_GET['activity']) ? $_GET['activity'] : '';
    $languageFilter = isset($_GET['language']) ? $_GET['language'] : '';

    try {
        // Requête SQL pour rechercher l'utilisateur par nom, prénom, activité et langue
        $sql = "SELECT id, prenom, nom FROM utilisateur WHERE (CONCAT(prenom, ' ', nom) LIKE :searchTerm OR CONCAT(nom, ' ', prenom) LIKE :searchTerm)";
        // Si un filtre d'activité est spécifié, l'ajouter à la requête
        if (!empty($activityFilter)) {
            $sql .= " AND acts LIKE :activityFilter";
        }
        // Si un filtre de langue est spécifié, l'ajouter à la requête
        if (!empty($languageFilter)) {
            $sql .= " AND langage LIKE :languageFilter";
        }
        // Limiter les résultats à 3 pour des raisons de performance
        $sql .= " LIMIT 3";

        // Préparation de la requête
        $query = $db->prepare($sql);
        // Remplacement des paramètres dans la requête
        $query->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);
        // Si un filtre d'activité est spécifié, le lier à la requête
        if (!empty($activityFilter)) {
            $query->bindValue(':activityFilter', '%' . $activityFilter . '%', PDO::PARAM_STR);
        }
        // Si un filtre de langue est spécifié, le lier à la requête
        if (!empty($languageFilter)) {
            $query->bindValue(':languageFilter', '%' . $languageFilter . '%', PDO::PARAM_STR);
        }
        // Exécution de la requête
        $query->execute();
        // Récupération des résultats
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
