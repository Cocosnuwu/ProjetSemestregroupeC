<?php
include '../include/database.php';

$query = $_GET['query'];
$sql = "SELECT id, Prenom, Nom FROM utilisateur WHERE Prenom LIKE :query OR Nom LIKE :query LIMIT 10";
$stmt = $db->prepare($sql);
$stmt->execute(array(':query' => '%' . $query . '%'));
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($results);
?>
