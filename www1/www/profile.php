<?php
session_start();

// Inclure le fichier de base de données
include 'include/database.php';

// Récupérer l'ID de l'utilisateur connecté depuis la session
$user_id = $_SESSION['user']['id'];

// Connexion à la base de données
// Assurez-vous que $db est défini correctement dans 'include/database.php'

// Initialise la variable $peut_personnaliser
$peut_personnaliser = true; // Par défaut, l'utilisateur peut personnaliser

// Définir le chemin vers le dossier des GIFs
$gif_dir = 'gif/';

// Obtenez la liste des fichiers GIF dans le dossier
$gifFiles = glob($gif_dir . '*.gif');

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer la description de l'utilisateur
    $des = isset($_POST['description']) ? $_POST['description'] : '';

    // Récupérer les activités favorites sélectionnées
    $acts = isset($_POST['acts']) ? $_POST['acts'] : [];

    // Récupérer les GIFs sélectionnés
    $gif1 = isset($_POST['gif1']) ? $_POST['gif1'] : '';
    $gif2 = isset($_POST['gif2']) ? $_POST['gif2'] : '';

    // Insérer les données dans la base de données
    // Assurez-vous d'ajuster les requêtes d'insertion en fonction de votre schéma de base de données
    $query = $db->prepare("UPDATE utilisateur SET des = :des, acts = :acts, gif1 = :gif1, gif2 = :gif2 WHERE id = :user_id");
    $query->execute(array(
        ':user_id' => $user_id,
        ':des' => $des,
        ':acts' => implode(',', $acts), // Convertir le tableau en chaîne de caractères
        ':gif1' => $gif1,
        ':gif2' => $gif2
    ));

    // Traitement des images téléchargées (pour les premières photos)
    if (isset($_FILES['photo'])) {
        $upload_dir = 'img/';
        $photoCount = min(count($_FILES['photo']['name']), 6); // Limite à 6 photos
        for ($i = 0; $i < $photoCount; $i++) {
            $file = $_FILES['photo'];
            if ($file['error'][$i] === UPLOAD_ERR_OK) {
                $mime_type = mime_content_type($file['tmp_name'][$i]);
                if (substr($mime_type, 0, 5) == 'image') {
                    $upload_file = $upload_dir . $user_id . '_photo_' . ($i + 1) . '_' . basename($file['name'][$i]);
                    if (move_uploaded_file($file['tmp_name'][$i], $upload_file)) {
                        // Mettre à jour la base de données avec le nom de l'image
                        if ($i == 0) {
                            $fieldName = 'photo'; // Utiliser 'photo' pour la première photo
                        } else {
                            $fieldName = 'photo' . ($i + 1); // Utiliser 'photo1', 'photo2', etc. pour les autres photos
                        }
                        $query = $db->prepare("UPDATE utilisateur SET $fieldName = :photo WHERE id = :user_id");
                        $query->execute(array(':photo' => $upload_file, ':user_id' => $user_id));
                        echo "Le fichier $i a été téléchargé avec succès.<br>";
                    } else {
                        echo "Une erreur s'est produite lors du téléchargement du fichier $i.<br>";
                    }
                } else {
                    echo "Le fichier téléchargé $i n'est pas une image valide.<br>";
                }
            } else {
                echo "Une erreur s'est produite lors du téléchargement du fichier $i.<br>";
            }
        }
    }

    // Traitement des images téléchargées (pour les photos supplémentaires)
    for ($i = 1; $i <= 5; $i++) {
        if (isset($_FILES['photo' . $i])) {
            $file = $_FILES['photo' . $i];
            if ($file['error'] === UPLOAD_ERR_OK) {
                $mime_type = mime_content_type($file['tmp_name']);
                if (substr($mime_type, 0, 5) == 'image') {
                    $upload_file = $upload_dir . $user_id . '_photo' . $i . '_' . basename($file['name']);
                    if (move_uploaded_file($file['tmp_name'], $upload_file)) {
                        // Mettre à jour la base de données avec le nom de l'image
                        $fieldName = 'photo' . $i;
                        $query = $db->prepare("UPDATE utilisateur SET $fieldName = :photo WHERE id = :user_id");
                        $query->execute(array(':photo' => $upload_file, ':user_id' => $user_id));
                        echo "Le fichier photo$i a été téléchargé avec succès.<br>";
                    } else {
                        echo "Une erreur s'est produite lors du téléchargement du fichier photo$i.<br>";
                    }
                } else {
                    echo "Le fichier téléchargé photo$i n'est pas une image valide.<br>";
                }
            } else {
                echo "Une erreur s'est produite lors du téléchargement du fichier photo$i.<br>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Rencontre Prof</title>
    <link rel="stylesheet" href="css/profil.css">
    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile {
            margin-bottom: 20px;
        }
        h2 {
            color: #333;
        }
        label {
            font-weight: bold;
            color: #555;
        }
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .public-profile-btn {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        // Informations de l'utilisateur (à remplacer par les données de la base de données)
        $query = $db->prepare("SELECT Nom, Prenom, age, des FROM utilisateur WHERE id = :user_id");
        $query->execute(array(':user_id' => $user_id));
        $user = $query->fetch();
        
        $prenom = $user['Prenom'];
        $nom = $user['Nom'];
        $des = $user['des'];

        // Affichage du profil
        echo '<div class="profile">';
        echo '<h2>Profil de ' . $prenom . ' ' . $nom . '</h2>';
        echo '<p>Description : ' . $des . '</p>';

        // Formulaire pour la description, les activités favorites et les GIFs
        echo '<h3>Personnalisation :</h3>';
        echo '<form action="" method="post" enctype="multipart/form-data">';
        echo '<label for="description">Description :</label><br>';
        echo '<textarea name="description" rows="4" cols="50">' . $des . '</textarea><br>';

        // Récupérer les activités favorites de l'utilisateur
        $query_user_acts = $db->prepare("SELECT acts FROM utilisateur WHERE id = :user_id");
        $query_user_acts->execute(array(':user_id' => $user_id));
        $user_acts_row = $query_user_acts->fetch();
        $user_acts = explode(',', $user_acts_row['acts']);

        // Liste des activités disponibles
        $query_activites = $db->query("SELECT * FROM activites");
        $activites = $query_activites->fetchAll(PDO::FETCH_ASSOC);

        echo '<p>Choisissez vos activités préférées :</p>';
        echo '<select name="acts[]" multiple>';
        foreach ($activites as $activite) {
            $selected = in_array($activite['id'], $user_acts) ? 'selected' : '';
            echo '<option value="' . $activite['id'] . '" ' . $selected . '>' . $activite['nom'] . '</option>';
        }
        echo '</select><br>';

        // Liste des GIFs disponibles (numérotées de 1 à 100)
        echo '<p>Choisissez vos gifs préférés :</p>';
        echo '<label for="gif1">GIF 1 :</label>';
        echo '<select name="gif1" id="gif1">';
        foreach ($gifFiles as $index => $gifFile) {
            $gifName = basename($gifFile);
            echo '<option value="' . ($index + 1) . '">' . $gifName . '</option>';
        }
        echo '</select><br>';
        echo '<label for="gif2">GIF 2 :</label>';
        echo '<select name="gif2" id="gif2">';
        foreach ($gifFiles as $index => $gifFile) {
            $gifName = basename($gifFile);
            echo '<option value="' . ($index + 1) . '">' . $gifName . '</option>';
        }
        echo '</select><br>';

        // Champs pour télécharger des photos
        echo '<label for="photo">Télécharger des photos :</label><br>';
        echo '<input type="file" name="photo[]" accept="image/*" multiple><br>';
        for ($i = 1; $i <= 5; $i++) {
            echo '<label for="photo' . $i . '">Photo ' . $i . ' :</label><br>';
            echo '<input type="file" name="photo' . $i . '" accept="image/*"><br>';
        }

        echo '<input type="submit" value="Enregistrer">';
        echo '</form>';
        echo '</div>';

        // Bouton pour voir le profil en mode public
        echo '<div>';
        echo '<form action="voir.php" method="get">';
        echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
        echo '<input type="submit" value="Voir le profil public">';
        echo '</form>';
        echo '</div>';
        ?>
    </div>
</body>
</html>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var selectedActivities = [];

    function updateSelectedActivities() {
        var selectedActivitiesContainer = document.getElementById('selected-activities');
        selectedActivitiesContainer.innerHTML = '';

        selectedActivities.forEach(function(activity) {
            var activityElement = document.createElement('div');
            activityElement.textContent = activity;
            selectedActivitiesContainer.appendChild(activityElement);
        });
    }

    document.querySelectorAll('select[name="acts[]"]').forEach(function(select) {
        select.addEventListener('dblclick', function(event) {
            var selectedActivity = event.target.value;
            if (selectedActivities.indexOf(selectedActivity) === -1 && selectedActivities.length < 2) {
                selectedActivities.push(selectedActivity);
                updateSelectedActivities();
            }
        });
    });
});
</script>
