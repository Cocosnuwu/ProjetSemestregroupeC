<?php
include 'include/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mail = $_POST['email'];
    $mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];
    $age = $_POST['age'];

    // Vérification des mots de passe
    if ($mdp !== $mdp2) {
        echo "<p class='error'>Les mots de passe ne correspondent pas.</p>";
    } else {
        // Cryptage du mot de passe
        $hashed_password = password_hash($mdp, PASSWORD_DEFAULT);

        try {
            // Vérifier si l'adresse e-mail existe déjà dans la base de données
            $query = $db->prepare("SELECT * FROM utilisateur WHERE mail = :mail");
            $query->execute(array(':mail' => $mail));
            $count = $query->rowCount();

            if ($count > 0) {
                echo "<p class='error'>Cette adresse e-mail est déjà utilisée.</p>";
            } else {
                // Insertion des données dans la base de données avec le mot de passe crypté
                $q = $db->prepare("INSERT INTO utilisateur(Nom, Prenom, age, mail, password) VALUES(:nom, :prenom, :age, :mail, :password)"); 
                $q->execute(array(':nom' => $nom, ':prenom' => $prenom, ':age' => $age, ':mail' => $mail, ':password' => $hashed_password));

                // Redirection après l'inscription
                header("Location: choixdeconnexion.php");
                exit(); // Arrêter l'exécution du script après la redirection
            }
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            echo "<p class='error'>Une erreur s'est produite lors de l'inscription : " . $e->getMessage() . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="css/inscription.css">
</head>

<body>
    <div class="container">
        <h2>Inscription</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="email">Mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe:</label>
                <input type="password" id="mdp" name="mdp" required>
            </div>
            <div class="form-group">
                <label for="mdp2">Vérification mot de passe:</label>
                <input type="password" id="mdp2" name="mdp2" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" min="0" max="200" />
            </div>
            <button type="submit" class="btn">S'inscrire</button>
        </form>
    </div>
</body>

</html>
