<?php
session_start();
?>

<?php
// Inclure le fichier de base de données
include 'include/database.php';

// Récupérer l'ID de l'utilisateur connecté depuis la session
$user_id = $_SESSION['user']['id'];

// Récupérer la valeur du champ "vua" de l'utilisateur depuis la base de données
$query = $db->prepare("SELECT vua FROM utilisateur WHERE id = :user_id");
$query->execute(array(':user_id' => $user_id));
$user = $query->fetch();

// Vérifier si l'utilisateur est abonné (vua = 1)
$is_subscribed = ($user['vua'] == 1 or $user['vua'] == 2 );

// Vérifier si l'utilisateur est abonné (vua = 1)
$is_host = ($user['vua'] == 2);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Abonné</title>
  <link rel="stylesheet" href="css/menuabonne.css">
</head>

<body>
  <header>
    <div class="logo">
      <a href="#">RencontreProfs</a>
    </div>
    <div class="search-container"> <!-- Container pour la barre de recherche -->
      <div class="search-bar">
        <input type="search" id="site-search" name="q" placeholder="Rechercher des professeurs...">
        <div id="search-results" class="search-results"></div>
      </div>
    </div>
    <nav>
      <ul>
        <li><a href="menuabonne.php">Accueil</a></li>
        <li class="dropdown">
          <a href="#" class="dropbtn">Mon Compte</a>
          <div class="dropdown-content">
            <a href="profile.php">Gestion de mon compte</a>
            <?php if ($is_host): ?>
                <a href="voirlesignalement.php">Traiter les signalements</a>
                <a href="gestionadmin.php">Gestion Admin</a>
            <?php endif; ?>
            <?php if ($is_subscribed): ?>
                <a href="listesignalement.php">Signalement</a>
                <a href="messagerie.php">Messagerie</a>
                <a href="consultation.php?user_id=<?php echo $user_id; ?>" class="view-button">Consultation du compte</a>
            
            <?php else: ?>
              <a href="pub.php" style="color: grey;">Messagerie (abonnés uniquement)</a>
              <a href="pub.php" style="color: grey;">Consultation du compte (abonnés uniquement)</a>
            <?php endif; ?>
          </div>
        </li>
       </ul>
    </nav>
    <a class="connexion" href="include/logout.php">Deconnexion</a>
  </header>
</body>

  <script src="js/scriptabonne.js"></script>
</body>

</html>