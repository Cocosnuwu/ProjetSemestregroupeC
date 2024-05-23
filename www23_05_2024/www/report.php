<?php
// Connexion à la base de données
include 'include/database.php';

// Récupérer le corps de la requête
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['userId']) && isset($data['reason'])) {
    $userId = $data['userId'];
    $reason = $data['reason'];

    try {
        $stmt = $db->prepare("INSERT INTO Signalement (ident, idée, raison, traité) VALUES (?, 0, ?, 0)");
        $stmt->execute([$userId, $reason]);
        echo json_encode(["success" => true]);
    } catch (PDOException $e) {
        http_response_code(500); // Définir le code de réponse HTTP sur 500 (Erreur interne du serveur)
        echo json_encode(["success" => false, "message" => "Erreur de la base de données: " . $e->getMessage()]);
    }
} else {
    http_response_code(400); // Définir le code de réponse HTTP sur 400 (Requête incorrecte)
    echo json_encode(["success" => false, "message" => "Données incomplètes"]);
}
?>
