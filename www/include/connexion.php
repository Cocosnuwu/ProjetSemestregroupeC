<?php
session_start();
include 'database.php';
global $db;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $lemail = $_POST['lemail'];
    $lmdp = $_POST['lmdp'];

    echo "Email récupéré depuis le formulaire : " . $lemail . "<br>";
    echo "Mot de passe récupéré depuis le formulaire : " . $lmdp . "<br>";

    // Vérification des champs non vides
    if (!empty($lemail) && !empty($lmdp)) {
        try {
            // Vérification de l'email dans la base de données
            $q = $db->prepare("SELECT * FROM utilisateur WHERE mail = :mail");
            $q->execute(['mail' => $lemail]);
            $result = $q->fetch();

            if ($result) {
                // Le compte existe
                if (password_verify($lmdp, $result['password'])) {
                    // Connexion réussie, stockage des informations de l'utilisateur dans la session
                    $_SESSION['user'] = $result;
                    // Redirection vers le menu utilisateur
                    header("Location: ../menuabonne.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Le mot de passe est incorrect";
                    echo "Mot de passe incorrect";
                }
            } else {
                $_SESSION['error'] = "Le compte portant l'email $lemail n'existe pas";
                echo "Compte inexistant";
            }
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            $_SESSION['error'] = "Une erreur s'est produite lors de la connexion : " . $e->getMessage();
            echo "Erreur PDO : " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Veuillez compléter tous les champs";
        echo "Champs vides";
    }
}

// Redirection vers la page de connexion
header("Location: ../connexion.php");
exit();
?>
