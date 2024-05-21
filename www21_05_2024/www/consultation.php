<?php
// Inclure le fichier de base de données
include 'include/database.php';

// Récupérer l'ID de l'utilisateur dont le profil a été consulté
$user_id = $_GET['user_id'];

// Récupérer les données de consultation depuis la base de données
$query = $db->prepare("SELECT consultation.jour, utilisateur.Nom, utilisateur.Prenom FROM consultation INNER JOIN utilisateur ON consultation.id = utilisateur.id WHERE consultation.idvew = :user_id ORDER BY consultation.jour ASC");
$query->execute(array(':user_id' => $user_id));
$rows = $query->fetchAll(PDO::FETCH_ASSOC);

// Initialiser les tableaux pour stocker les dates et les visiteurs
$dates = array();
$visitors = array();

// Parcourir les résultats et remplir les tableaux
foreach ($rows as $row) {
    $dates[] = $row['jour'];
    $visitors[] = array(
        'Nom' => $row['Nom'],
        'Prenom' => $row['Prenom'],
        'Date' => $row['jour']
    );
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visiteurs du profil</title>
    <link rel="stylesheet" href="css/consultation.css">
</head>
<body>
    <div class="container">
        <h1>Visiteurs du profil</h1>
        <?php
        if ($visitors && count($visitors) > 0) {
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($visitors as $visitor): ?>
                        <tr>
                            <td><?php echo $visitor['Nom']; ?></td>
                            <td><?php echo $visitor['Prenom']; ?></td>
                            <td><?php echo $visitor['Date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php
        } else {
            echo "<p>Aucun visiteur n'a consulté votre profil aujourd'hui.</p>";
        }
        ?>
        <a href="menuabonne.php" class="back-button">Retour au menu</a>
    </div>
</body>
</html>
