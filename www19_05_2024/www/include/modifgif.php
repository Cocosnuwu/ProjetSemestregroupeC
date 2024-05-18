<?php
session_start();

// Inclure le fichier de base de données
include 'database.php';

// Récupérer l'ID de l'utilisateur connecté depuis la session
$user_id = $_SESSION['user']['id'];



// Initialise la variable $peut_personnaliser
$peut_personnaliser = true; // Par défaut, l'utilisateur peut personnaliser

// Définir le chemin vers le dossier des GIFs
$gif_dir = '../gif/';

// Obtenez la liste des fichiers GIF dans le dossier
$gifFiles = glob($gif_dir . "*.gif");

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les GIFs sélectionnés
    $gif1 = isset($_POST['gif1']) ? $_POST['gif1'] : '';
    $gif2 = isset($_POST['gif2']) ? $_POST['gif2'] : '';

    // Insérer les données dans la base de données
    // Assurez-vous d'ajuster les requêtes d'insertion en fonction de votre schéma de base de données
    $query = $db->prepare("UPDATE utilisateur SET gif1 = :gif1, gif2 = :gif2 WHERE id = :user_id");
    $query->execute(array(
        ':user_id' => $user_id,
        ':gif1' => $gif1,
        ':gif2' => $gif2
    ));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personnalisation du Profil - Rencontre Prof</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/modifgif.css">
</head>
<body>
    <div class="container">
        <h1>Personnalisez votre profil</h1>
        <div class="gif-selector">
            <button class="gif-button" onclick="toggleGifOptions('gif1')">
                <div class="gif-circle"></div>
                    <?php if (!empty($gif1)) { ?>
                        <img src="../gif/<?php echo $gif1;?>" alt="GIF">
                    <?php } else { ?>
                        <div class="placeholder"></div>
                    <?php } ?>
            </button>
            <div class="gif-options" id="gif1-options">
                <?php foreach ($gifFiles as $gifFile) { ?>
                    <img src="<?php echo $gifFile; ?>" alt="GIF" onclick="selectGif('gif1', '<?php echo basename($gifFile); ?>')">
                <?php } ?>
            </div>
        </div>
        <div class="gif-selector">
             <button class="gif-button" onclick="toggleGifOptions('gif2')">
                 <div class="gif-circle"></div>
                <?php if (!empty($gif2)) { ?>
                    <img src="../gif/<?php echo $gif2;?>" alt="GIF">
                <?php } else { ?>
                    <div class="placeholder"></div>
                <?php } ?>
            </button>
            <div class="gif-options" id="gif2-options">
                <?php foreach ($gifFiles as $gifFile) { ?>
                    <img src="<?php echo $gifFile; ?>" alt="GIF" onclick="selectGif('gif2', '<?php echo basename($gifFile); ?>')">
                <?php } ?>
            </div>
        </div>
        <form action="" method="post">
            <input type="hidden" name="gif1" id="gif1" value="<?php echo $gif1; ?>">
            <input type="hidden" name="gif2" id="gif2" value="<?php echo $gif2; ?>">
            <input type="submit" name="submit" value="Enregistrer">
        </form>
        <div class="exit-btn">
            <?php
            echo '<form action="../profile.php" method="get">';
            echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
            echo '<input type="submit" value="Quitter">';
            ?>
        </div>
    </div>

    <script>
        function toggleGifOptions(gifId) {
            var gifOptions = document.getElementById(gifId + '-options');
            gifOptions.style.display = gifOptions.style.display === 'none' ? 'block' : 'none';
        }

        function selectGif(gifId, gifName) {
            var gifInput = document.getElementById(gifId);
            gifInput.value = gifName;
            var gifSelector = document.querySelector('.' + gifId + '-selector button');
            gifSelector.innerHTML = '<img src="../gif/' + gifName + '" alt="GIF">';
            toggleGifOptions(gifId);
        }
    </script>
</body>
</html>




