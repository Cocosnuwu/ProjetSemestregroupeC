<?php
session_start();

// Inclure le fichier de base de données
include 'include/database.php';

$user_id = $_SESSION['user']['id'];

// Récupérer l'ID de la page consultée
$page_id = $_GET['user_id'];

// Vérifier si l'utilisateur a déjà consulté cette page aujourd'hui
$today = date('Y-m-d');
$query = $db->prepare("SELECT COUNT(*) as count FROM consultation WHERE jour = :jour AND id = :id AND idvew = :idvew");
$query->execute(array(':jour' => $today, ':id' => $user_id, ':idvew' => $page_id));
$result = $query->fetch(PDO::FETCH_ASSOC);

if ($result['count'] == 0) {
    try {
        // Insérer une nouvelle ligne dans la table consultation
        $query = $db->prepare("INSERT INTO consultation (id, consult, jour, idvew) VALUES (:id, 1, :jour, :idvew)");
        $query->execute(array(':id' => $user_id, ':jour' => $today, ':idvew' => $page_id));
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    try {
        // Incrémenter le nombre de consultations pour cette page aujourd'hui
        $query = $db->prepare("UPDATE consultation SET consult = consult + 1 WHERE jour = :jour AND id = :id AND idvew = :idvew");
        $query->execute(array(':jour' => $today, ':id' => $user_id, ':idvew' => $page_id));
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
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

				<button class="btn profile-edit-btn">Edit Profile</button>

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

			</div>

		</div>
		<!-- End of profile section -->

	</div>
	<!-- End of container -->

</body>
<main>

	<div class="container">

		<div class="gallery">

			<?php if (!empty($user["photo1"])): ?>
                <div class="gallery-item" tabindex="0">
                    <img src="<?php echo $user["photo1"]; ?>" class="gallery-image" alt="">
                    <div class="gallery-item-info">
                        <ul>
                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fas fa-heart" aria-hidden="true"></i></li>
                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fas fa-comment" aria-hidden="true"></i></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            
            
			<?php if (!empty($user["photo2"])): ?>
                <div class="gallery-item" tabindex="0">
                    <img src="<?php echo $user["photo2"]; ?>" class="gallery-image" alt="">
                    <div class="gallery-item-info">
                        <ul>
                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fas fa-heart" aria-hidden="true"></i></li>
                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fas fa-comment" aria-hidden="true"></i></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            
            
            <?php if (!empty($user["photo3"])): ?>
                <div class="gallery-item" tabindex="0">
                    <img src="<?php echo $user["photo3"]; ?>" class="gallery-image" alt="">
                    <div class="gallery-item-info">
                        <ul>
                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fas fa-heart" aria-hidden="true"></i></li>
                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fas fa-comment" aria-hidden="true"></i></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            
            
            <?php if (!empty($user["photo4"])): ?>
                <div class="gallery-item" tabindex="0">
                    <img src="<?php echo $user["photo4"]; ?>" class="gallery-image" alt="">
                    <div class="gallery-item-info">
                        <ul>
                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fas fa-heart" aria-hidden="true"></i></li>
                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fas fa-comment" aria-hidden="true"></i></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            
            
            <?php if (!empty($user["photo5"])): ?>
                <div class="gallery-item" tabindex="0">
                    <img src="<?php echo $user["photo5"]; ?>" class="gallery-image" alt="">
                    <div class="gallery-item-info">
                        <ul>
                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fas fa-heart" aria-hidden="true"></i></li>
                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fas fa-comment" aria-hidden="true"></i></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            
            
            <?php if (!empty($user["photo6"])): ?>
                <div class="gallery-item" tabindex="0">
                    <img src="<?php echo $user["photo6"]; ?>" class="gallery-image" alt="">
                    <div class="gallery-item-info">
                        <ul>
                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fas fa-heart" aria-hidden="true"></i></li>
                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fas fa-comment" aria-hidden="true"></i></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($user["gif1"])): ?>
                <div class="gallery-item" tabindex="0">
                    <img src="gif/<?php echo $user["gif1"];?>" class="gallery-image" alt="">
                    <div class="gallery-item-info">
                        <ul>
                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fas fa-heart" aria-hidden="true"></i></li>
                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fas fa-comment" aria-hidden="true"></i></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            
            
			<?php if (!empty($user["photo7"])): ?>
                <div class="gallery-item" tabindex="0">
                    <img src="<?php echo $user["photo7"]; ?>" class="gallery-image" alt="">
                    <div class="gallery-item-info">
                        <ul>
                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fas fa-heart" aria-hidden="true"></i></li>
                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fas fa-comment" aria-hidden="true"></i></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

			<?php if (!empty($user["gif2"])): ?>
                <div class="gallery-item" tabindex="0">
                <img src="gif/<?php echo $user["gif2"];?>" class="gallery-image" alt="">
                    <div class="gallery-item-info">
                        <ul>
                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fas fa-heart" aria-hidden="true"></i></li>
                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fas fa-comment" aria-hidden="true"></i></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

		</div>
		<!-- End of gallery -->

		

	</div>
	<!-- End of container -->

</main>
<script src="js/scriptabonne.js"></script>
<script src="js/voir.js"></script>

</body>
</html>
