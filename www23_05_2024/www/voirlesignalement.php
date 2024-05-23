<?php
session_start();

// Vérifier si l'identifiant est présent dans l'URL
if (!isset($_GET['user_id']) || !is_numeric($_GET['user_id'])) {
    echo "Identifiant d'utilisateur invalide.";
    exit;
}

// Inclure le fichier de connexion à la base de données
include 'include/database.php';

// Récupérer l'identifiant de l'utilisateur depuis l'URL
$userId = $_GET['user_id'];

// Récupérer le champ vua de l'utilisateur
try {
    $stmt = $db->prepare("SELECT vua FROM utilisateur WHERE id = ?");
    $stmt->execute([$userId]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de la base de données : " . $e->getMessage();
    exit;
}

// Vérifier si l'utilisateur a les droits d'administrateur
if ($userData['vua'] != 2) {
    echo "Vous n'êtes pas autorisé à accéder à cette page.";
    exit;
}

// Marquer un signalement comme traité si demandé
if (isset($_POST['markAsTreated']) && is_numeric($_POST['signalementId'])) {
    $signalementId = $_POST['signalementId'];
    try {
        $stmt = $db->prepare("UPDATE Signalement SET traité = 1 WHERE ident = ? AND idée = ?");
        $stmt->execute([$userId, $signalementId]);
    } catch (PDOException $e) {
        echo "Erreur de la base de données : " . $e->getMessage();
        exit;
    }
}

// Récupérer les signalements non traités pour l'utilisateur spécifié
try {
    $stmt = $db->prepare("SELECT * FROM Signalement WHERE ident = ? AND traité = 0");
    $stmt->execute([$userId]);
    $signalements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur de la base de données : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signalements de l'Utilisateur</title>
    <link rel="stylesheet" href="css/voirlesignalement.css">
</head>
<body>
    <div class="container">
        <a href="menuabonne.php" class="back-button">Retour</a>
        <h1>Liste des Signalements de l'Utilisateur</h1>
        <?php if (!empty($signalements)) : ?>
            <ul>
                <?php foreach ($signalements as $signalement) : ?>
                    <li class="signalement">
                        <div>
                            <strong>Raison:</strong> <?php echo htmlspecialchars($signalement['raison']); ?><br>
                            <strong>Traité:</strong> <?php echo $signalement['traité'] ? 'Oui' : 'Non'; ?><br>
                        </div>
                        <form method="post" action="">
                            <input type="hidden" name="signalementId" value="<?php echo $signalement['idée']; ?>">
                            <button type="submit" name="markAsTreated" class="traiter-button">Marquer comme traité</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Aucun signalement pour cet utilisateur.</p>
        <?php endif; ?>
    </div>
</body>
</html>
