<?php
include '../include/database.php';

$query = $_GET['query'];
$sql = "SELECT utilisateur.id, utilisateur.Prenom, utilisateur.Nom FROM utilisateur LEFT JOIN messagerie ON utilisateur.id = messagerie.id2 WHERE (utilisateur.Prenom LIKE :query OR utilisateur.Nom LIKE :query) AND (messagerie.id1 != :current_user_id OR messagerie.id1 IS NULL) AND (messagerie.blocage = 0 OR messagerie.blocage IS NULL) GROUP BY utilisateur.id LIMIT 10";
$stmt = $db->prepare($sql);
$stmt->execute(array(':query' => '%' . $query . '%', ':current_user_id' => $_SESSION['user']['id']));
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>
