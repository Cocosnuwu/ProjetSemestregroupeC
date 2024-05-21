<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="css/connexion.css">
</head>

<body>
    <div class="container">
        <h2>Connexion</h2>
        <form action="include/connexion.php" method="post">
            <div class="form-group">
                <label for="lemail">E-mail:</label>
                <input type="email" id="lemail" name="lemail" required>
            </div>
            <div class="form-group">
                <label for="lmdp">Mot de passe:</label>
                <input type="password" id="lmdp" name="lmdp" required>
            </div>
            <button type="submit" class="btn">Se connecter</button>
        </form>
        <?php
        if(isset($_SESSION['error'])){
            echo '<p class="error">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        ?>
    </div>
</body>

</html>
