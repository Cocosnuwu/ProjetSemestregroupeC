


<?php

// Inclure le fichier de base de données
include 'include/database.php';


// Récupérer trois utilisateurs aléatoires
$query = $db->prepare("SELECT id, Nom, Prenom, photo, langage FROM utilisateur ORDER BY RAND() LIMIT 3");
$query->execute();
$users = $query->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="search-container"> <!-- Container pour la barre de recherche -->
      <div class="search-bar">
        <input type="search" id="site-search" name="q" placeholder="Rechercher des professeurs...">
        <div id="search-results" class="search-results"></div>
      </div>
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Accueil</a></li>
        
       </ul>
    </nav>
    <a class="connexion" href="choixdeconnexion.php">Connexion</a>
  </header>
  <main>
      <div class="main-container">
        <div class="random-users-container">
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
    
    
    <div class="background-image"></div>
</main>
    <section class="hero">
    <div class="container">
      <h2 class="hero-title">Rencontrez des professionnels de l'informatique</h2>
      <p class="hero-text">Trouvez des collègues passionnés et partagez vos expériences</p>
      <a href="choixdeconnexion.php" class="btn">S'inscrire</a>
    </div>
  </section>
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
  <script src="js/index.js"></script>
</body>

</html>

