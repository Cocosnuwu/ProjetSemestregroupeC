<?php
session_start();

// Inclure le fichier de base de données
include 'include/database.php';

$user_id = $_SESSION['user']['id'];

// Récupérer l'ID de l'utilisateur depuis l'URL
if(isset($_GET['user_id']) && !empty($_GET['user_id'])){
    $id = $_GET['user_id'];
    
    try {
        // Préparer la requête SQL
        $query = $db->prepare("SELECT Nom, Prenom, age, des, acts, langage, gif1, gif2, photo, photo1, photo2, photo3, photo4, photo5 FROM utilisateur WHERE id = :id");
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
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="css/voir.css">
</head>
<body>

<header>

	<div class="container">

		<div class="profile">

			<div class="profile-image">

				<img src="https://images.unsplash.com/photo-1513721032312-6a18a42c8763?w=152&h=152&fit=crop&crop=faces" alt="">

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

</header>

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
                    <img src="gif/<?php echo $user["gif1"];?>.gif" class="gallery-image" alt="">
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
                <img src="gif/<?php echo $user["gif2"];?>.gif" class="gallery-image" alt="">
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

<script src="voir.js"></script>

</body>
</html>
