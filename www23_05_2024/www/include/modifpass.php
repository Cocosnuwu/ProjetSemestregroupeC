<?php
session_start();

// Inclure le fichier de base de données
include 'database.php';
// Récupérer l'ID de la page consultée
        $page_id = $_GET['user_id'];
// Récupérer l'ID de l'utilisateur connecté depuis la session
$user_id = $_SESSION['user']['id'];

// Obtenez les activités favorites de l'utilisateur
$query_user_acts = $db->prepare("SELECT acts FROM utilisateur WHERE id = :user_id");
$query_user_acts->execute(array(':user_id' => $user_id));
$user_acts_row = $query_user_acts->fetch();
$user_acts = explode(',', $user_acts_row['acts']);

// Obtenez la liste des activités disponibles
$query_activites = $db->query("SELECT * FROM activites");
$activites = $query_activites->fetchAll(PDO::FETCH_ASSOC);

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer la langue informatique de l'utilisateur
    $langage = isset($_POST['langage']) ? $_POST['langage'] : '';
    
    // Récupérer les activités favorites sélectionnées
    $acts = isset($_POST['acts']) ? $_POST['acts'] : [];

    // Insérer les données dans la base de données
    // Assurez-vous d'ajuster les requêtes d'insertion en fonction de votre schéma de base de données
    $query = $db->prepare("UPDATE utilisateur SET langage = :langage, acts = :acts WHERE id = :user_id");
    $query->execute(array(
        ':user_id' => $page_id,
        ':langage' => $langage,
        ':acts' => implode(',', $acts), // Convertir le tableau en chaîne de caractères
    ));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Rencontre Prof</title>
    <link rel="stylesheet" type="text/css" href="css/profil.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8f0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        select,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            color: #333;
        }

        select[multiple] {
            height: 120px;
        }

        input[type="submit"] {
            cursor: pointer;
            background-color: #4caf50;
            color: #fff;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        #cancelButton {
            background-color: #ff6b6b;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        #cancelButton:hover {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile">
            <form id="profileForm" method="post">
                <?php
                // Liste des langages de programmation favoris
                echo'<label for="langage">Langage de programmation favori :</label><br>';
                echo'<select name="langage" id="langage">';
                echo   '<option value="C">C</option>';
                echo    '<option value="C++">C++</option>';
                echo    '<option value="Java">Java</option>';
                echo    '<option value="Python">Python</option>';
                echo    '<option value="JavaScript">JavaScript</option>';
                echo '</select><br>';

                // Liste des activités disponibles
                echo '<p>Choisissez vos activités préférées :</p>';
                echo '<select name="acts[]" id="acts" multiple>';
                foreach ($activites as $activite) {
                    $selected = in_array($activite['id'], $user_acts) ? 'selected' : '';
                    echo '<option value="' . $activite['id'] . '" ' . $selected . '>' . $activite['nom'] . '</option>';
                }
                echo '</select><br>';
                ?>
                <input type="submit" value="Enregistrer">
            </form>
        </div>

        <!-- Bouton pour sortir de la personnalisation -->
        <div>
            <a href="../profile.php?user_id=<?php echo $page_id; ?>"><button id="cancelButton">Quitter sans enregistrer</button></a>
        </div>
    </div>
</body>
</html>


