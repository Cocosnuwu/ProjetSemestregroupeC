<?php
session_start();

// Inclure le fichier de base de données
include 'database.php';

// Récupérer l'ID de l'utilisateur connecté depuis la session
$user_id = $_SESSION['user']['id'];

// Initialise la variable $peut_personnaliser
$peut_personnaliser = true; // Par défaut, l'utilisateur peut personnaliser

// Fonction pour rogner l'image
function cropImage($file, $width, $height, $output) {
    list($w, $h) = getimagesize($file);
    $src = imagecreatefromstring(file_get_contents($file));

    // Calculer les proportions
    $aspect_ratio = $w / $h;
    $new_width = $width;
    $new_height = $height;

    if ($aspect_ratio > 1) {
        // L'image est plus large que haute
        $new_height = $height;
        $new_width = $width * $aspect_ratio;
    } else {
        // L'image est plus haute que large
        $new_width = $width;
        $new_height = $height / $aspect_ratio;
    }

    // Redimensionner l'image
    $temp_image = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($temp_image, $src, 0, 0, 0, 0, $new_width, $new_height, $w, $h);

    // Rogner l'image
    $dst = imagecreatetruecolor($width, $height);
    $x = ($new_width - $width) / 2;
    $y = ($new_height - $height) / 2;
    imagecopy($dst, $temp_image, 0, 0, $x, $y, $width, $height);

    imagejpeg($dst, $output);
    imagedestroy($src);
    imagedestroy($temp_image);
    imagedestroy($dst);
}

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Traitement des images téléchargées
    $upload_dir = '../img/';
    $db_upload_dir = 'img/';
    $allowed_types = array('image/jpeg', 'image/png');

    // Fonction pour gérer l'upload de photo
    function handlePhotoUpload($photoIndex, $user_id, $db, $upload_dir, $db_upload_dir, $allowed_types, $is_first_photo = false) {
        $input_name = $is_first_photo ? 'photo' : 'photo' . $photoIndex;
        if(isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES[$input_name]['tmp_name'];
            $file_type = $_FILES[$input_name]['type'];
            
            if(in_array($file_type, $allowed_types)) {
                $file_suffix = $is_first_photo ? 'photo' : 'photo' . $photoIndex;
                $target_file = $upload_dir . $user_id . '_' . $file_suffix . '.jpg';
                $db_target_file = $db_upload_dir . $user_id . '_' . $file_suffix . '.jpg';

                // Supprimer l'ancien fichier s'il existe
                if (file_exists($target_file)) {
                    unlink($target_file);
                }

                // Rogner l'image si c'est la première photo
                if ($is_first_photo) {
                    cropImage($file_tmp, 152, 152, $file_tmp);
                }

                if(move_uploaded_file($file_tmp, $target_file)) {
                    // Update database
                    $photoField = $is_first_photo ? 'photo' : 'photo' . $photoIndex;
                    $query = $db->prepare("UPDATE utilisateur SET $photoField = :photo WHERE id = :user_id");
                    $query->execute(array(':photo' => $db_target_file, ':user_id' => $user_id));
                    echo "Le fichier $photoField a été téléchargé avec succès.<br>";
                } else {
                    echo "Une erreur s'est produite lors du téléchargement de la photo$photoIndex.<br>";
                }
            } else {
                echo "Le type de fichier de la photo$photoIndex n'est pas pris en charge. Seuls les fichiers JPEG et PNG sont autorisés.<br>";
            }
        }
    }

    // Gérer l'upload pour la première photo
    handlePhotoUpload(1, $user_id, $db, $upload_dir, $db_upload_dir, $allowed_types, true);
    // Gérer l'upload pour les autres photos
    for ($i = 1; $i <= 8; $i++) {
        handlePhotoUpload($i, $user_id, $db, $upload_dir, $db_upload_dir, $allowed_types);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Rencontre Prof</title>
    <link rel="stylesheet" type="text/css" href="../css/modifphoto.css">
</head>
<body>
    <div class="container">
        <!-- Formulaire pour télécharger les photos -->
        <form action="" method="post" enctype="multipart/form-data">
            <label for="photo">Télécharger la première photo (152x152) :</label><br>
            <input type="file" name="photo" accept="image/*"><br>
            
            <label for="photo1">Télécharger les 7 autres photos :</label><br>
            <?php
            // Boucle pour afficher les champs pour télécharger les autres photos
            for ($i = 1; $i < 8; $i++) {
                echo '<input type="file" name="photo' . $i . '" accept="image/*"><br>';
            }
            ?>
            <input type="submit" value="Enregistrer">
        </form>
        <!-- Bouton pour sortir de la personnalisation -->
        <div class="exit-btn">
            <form action="../profile.php" method="get">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <input type="submit" value="Quitter">
            </form>
        </div>
    </div>
</body>
</html>
