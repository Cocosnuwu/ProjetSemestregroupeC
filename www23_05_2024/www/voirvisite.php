<?php
session_start();

// Inclure le fichier de base de données
include 'include/database.php';


// Récupérer l'ID de la page consultée
$page_id = $_GET['user_id'];


// Récupérer l'ID de l'utilisateur depuis l'URL
if(isset($_GET['user_id']) && !empty($_GET['user_id'])){
    $id = $_GET['user_id'];
    
    try {
        // Préparer la requête SQL
        $query = $db->prepare("SELECT Nom, Prenom, age, des, acts, langage, gif1, gif2, photo, photo1, photo2, photo3, photo4, photo5, photo6, photo7, vua FROM utilisateur WHERE id = :id");
        $query->execute(array(':id' => $id));
        $user = $query->fetch();
        
        $actId = $user['acts'];
        $query2 = $db->prepare("SELECT nom FROM activites WHERE id = :id");
        $query2->execute(array(':id' => $actId));
        $activity = $query2->fetch();
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "ID d'utilisateur non spécifié.";
}
//Vérification si l'utilisateur est bien l'utilisateur pour la fonction edit
/* $is = ($user['id'] == $user_id ); */

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
    <link rel="stylesheet" href="css/voir.css">
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
  

    
	<div class="container">

		<div class="profile">

			<div class="profile-image">
                <?php if (!empty($user["photo"])): ?>
                        <img src="<?php echo $user["photo"]; ?>"  alt="">
                <?php endif; ?>
			</div>

			<div class="profile-user-settings">

				<h1 class="profile-user-name"> 
				    <?php 
				        echo "<h1>Profil de " . $user["Nom"] . " " . $user["Prenom"] . "</h1>"; 
				    ?> 
				</h1>

				<a href="choixdeconnexion.php" class="profile-edit-btn">Discuter</a> 
				
				<button class="btn profile-settings-btn" aria-label="profile settings"><i class="fas fa-cog" aria-hidden="true"></i></button>

			</div>

			<div class="profile-stats">

				<ul>
				    <li>
					    <span class="profile-stat-count">Âge : <?php echo "<b>" . $user["age"] . "</b>"; ?>
					    </span> 
					</li>
					<li>
					    
					    <span class="profile-stat-count">Activité préférée : <?php echo "<b>" . htmlspecialchars($activity['nom']) . "</b>"; ?></span>

					    </span> 
					</li>
					<li>
					    <span class="profile-stat-count">Langage préféré : <?php echo "<b>" . $user["langage"] . "</b>"; ?>
					    </span> 
					</li>
					
				</ul>

			</div>

			<div class="profile-bio">

				<p>
				    <span class="profile-real-name">
				        <?php echo "<b>" . $user["Nom"] . " " . $user["Prenom"] . "</b>"; ?>
				    </span> <?php echo "<p>" . $user["des"] . "</p>"; ?>
				    
				    
				    
                </p>
                <b>
                  <p>
                    Pour en savoir plus inscrivez vous 😉
                </p>  
                </b>
                

			</div>

		</div>
		<!-- End of profile section -->

	</div>
	<!-- End of container -->

</body>
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
<script src="js/scriptabonne.js"></script>
<script src="js/voir.js"></script>

</body>
</html>
