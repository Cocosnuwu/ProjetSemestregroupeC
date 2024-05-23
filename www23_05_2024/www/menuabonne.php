<?php
session_start();

// Inclure le fichier de base de données
include 'include/database.php';

$user_id = $_SESSION['user']['id'];

// Récupérer trois utilisateurs aléatoires
$query = $db->prepare("SELECT id, Nom, Prenom, photo, langage FROM utilisateur ORDER BY RAND() LIMIT 3");
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les derniers inscrits
$latest_users_query = $db->prepare("SELECT Nom, Prenom, photo, langage FROM utilisateur ORDER BY id DESC LIMIT 1");
$latest_users_query->execute();
$latest_users = $latest_users_query->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les infos du profil actuel
$current_user_query = $db->prepare("SELECT Nom, Prenom, photo, langage FROM utilisateur WHERE id = ?");
$current_user_query->execute([$user_id]);
$current_user = $current_user_query->fetch(PDO::FETCH_ASSOC);
// Vérifier si le terme de recherche est présent et non vide
if(isset($_GET['search']) && !empty(trim($_GET['search']))) {
    // Récupération du terme de recherche
    $searchTerm = trim($_GET['search']);

    // Déterminer les valeurs des filtres d'activité et de langage
    $activityFilter = isset($_GET['activity']) ? $_GET['activity'] : '';
    $languageFilter = isset($_GET['language']) ? $_GET['language'] : '';

    // Préparer la requête SQL en fonction des filtres
    $query = "SELECT id, prenom, nom FROM utilisateur WHERE (CONCAT(prenom, ' ', nom) LIKE :searchTerm OR CONCAT(nom, ' ', prenom) LIKE :searchTerm)";

    if (!empty($activityFilter)) {
        $query .= " AND acts LIKE '%$activityFilter%'";
    }

    if (!empty($languageFilter)) {
        $query .= " AND langage LIKE '%$languageFilter%'";
    }

    $query .= " LIMIT 3";

    try {
        // Exécuter la requête SQL
        $stmt = $db->prepare($query);
        $stmt->execute([':searchTerm' => '%' . $searchTerm . '%']);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Abonné</title>
  <link rel="stylesheet" href="css/menuabonne.css">
  <link rel="stylesheet" href="css/random.css">
  <link rel="stylesheet" href="css/premium.css">
  <link rel="stylesheet" href="css/logo.css">
  <link rel="stylesheet" href="css/acceuil.css">
</head>

<body>
  <header>
    <div class="logo">
      <a href="#">RencontreProfs</a>
    </div>
    <div class="filter-container">
    <label for="activity-filter">Filtrer par activité :</label>
    <select id="activity-filter">
        <option value="">Toutes les activités</option>
        <?php
        $activities_query = $db->query("SELECT * FROM activites");
        while ($activity = $activities_query->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='".$activity['id']."'>".$activity['nom']."</option>";
        }
        ?>
    </select>

    <label for="language-filter">Filtrer par langage :</label>
    <select id="language-filter">
        <option value="">Tous les langages</option>
        <option value="C">C</option>
        <option value="C++">C++</option>
        <option value="Java">Java</option>
        <option value="Python">Python</option>
        <option value="JavaScript">JavaScript</option>
        </select>
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
            <a href="profile.php?user_id=<?php echo $_SESSION['user']['id']; ?>">Gestion de mon compte</a>
            <?php if ($_SESSION['user']['vua'] == 2): ?>
                <a href="voirlesignalement.php?user_id=<?php echo $_SESSION['user']['id']; ?>">Traiter les signalements</a>
                <a href="admin/gestionadmin.php">Gestion Admin</a>
            <?php endif; ?>
            <?php if ($_SESSION['user']['vua'] == 1 || $_SESSION['user']['vua'] == 2): ?>
                <a href="listesignalement.php">Signalement</a>
                <a href="messagerie/acceuilmessagerie.php?user_id=<?php echo $_SESSION['user']['id']; ?>">Messagerie</a>
                <a href="consultation.php?user_id=<?php echo $_SESSION['user']['id']; ?>" class="view-button">Consultation du compte</a>
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
  <main>
      <div class="main-container">
        <div class="random-users-container">
            <br /><br /><br />
            <?php foreach ($users as $user): ?>
            <div class="user-card">
                <img src="<?php echo $user['photo']; ?>" alt="Photo de <?php echo $user['Nom']; ?>" class="user-photo">
                <div class="user-info">
                    <h2><?php echo $user['Nom'] . ' ' . $user['Prenom']; ?></h2>
                    <p>Langage préféré: <?php echo $user['langage']; ?></p>
                </div>
                <div class="user-actions">
                    <a href="voir.php?user_id=<?php echo $user['id']; ?>" class="btn">Voir le profil</a>
                </div>
            </div>
            <?php endforeach; ?>
            <button onclick="window.location.reload();" class="btn-refresh">Changer les utilisateurs</button>
        </div>
    
    <aside class="premium-banner">
    <br /><br /><br />
  <h2>Voici pourquoi depuis que j'ai souscris à l'abonnement premium ma vie est bien meilleur</h2>
  <div class="video-container">
    <a href="lien_de_votre_video">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/7ypDbxIib_I" frameborder="0" allowfullscreen></iframe>
      

    </a>
    
  </div>
  <a href="pub.php" class="interested-btn">Je suis intéressé</a>
    <!-- Profil de l'utilisateur actuel -->
    <div class="current-user-info">
        <h2>Mon Profil</h2>
        <div class="user-card">
          <img src="<?php echo $current_user['photo']; ?>" alt="Photo de <?php echo $current_user['Nom']; ?>" class="user-photo">
          <div class="user-info">
            <h2><?php echo $current_user['Nom'] . ' ' . $current_user['Prenom']; ?></h2>
            <p>Langage préféré: <?php echo $current_user['langage']; ?></p>
          </div>
        </div>
      </div>

    <!-- Dernier inscrit -->
    <div class="latest-users-container">
        <h2>Derniers inscrits</h2>
        <?php foreach ($latest_users as $latest_user): ?>
          <div class="user-card">
            <img src="<?php echo $latest_user['photo']; ?>" alt="Photo de <?php echo $latest_user['Nom']; ?>" class="user-photo">
            <div class="user-info">
              <h2><?php echo $latest_user['Nom'] . ' ' . $latest_user['Prenom']; ?></h2>
              <p>Langage préféré: <?php echo $latest_user['langage']; ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
  
</aside>
    <div class="background-image"></div>
</main>

  <section class="features">
    <div class="container">
      <h2 class="section-title">Pourquoi choisir RencontreProfs ?</h2>
      <div class="feature">
        <h3 class="feature-title">Réseau Professionnel</h3>
        <p class="feature-text">Evitez les futures disputes de couples sur les meilleurs langages de programmations.</p>
      </div>
      <div class="feature">
        <h3 class="feature-title">Partage de bons moments</h3>
        <p class="feature-text">Partagez vos passions, découvrez celles des autres.</p>
      </div>
      <div class="feature">
        <h3 class="feature-title">Sécurisé et Privé</h3>
        <p class="feature-text">Vos données sont sécurisées et vous avez le contrôle total de votre vie privée.</p>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <p>&copy; 2024 RencontreProfs. Tous droits réservés.</p>
    </div>
  </footer>
  <script src="js/scriptabonne.js"></script>
</body>

</html>
