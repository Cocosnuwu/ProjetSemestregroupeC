<?php
session_start();
?>

<?php
// Inclure le fichier de base de données
include 'include/database.php';

// Récupérer l'ID de l'utilisateur connecté depuis la session
$user_id = $_SESSION['user']['id'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devenir Membre RencontreProfs</title>
    <link rel="stylesheet" href="css/pub.css">
</head>
  
<body>
  <header>
    <div class="logo">
      <a href="index.php">RencontreProfs</a>
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Accueil</a></li>
      </ul>
    </nav>
  </header>

  <div class="background-container"></div>
  <div class="container">
    <h1>Devenez Membre RencontreProfs</h1>
    <div class="pricing-table">
      
           <!-- Essai Gratuit -->
      <div class="pricing-plan">
        <div class="duration">1 semaine</div>
        <h3>Essai Gratuit</h3>
        <div class="price">0€</div>
        <ul>
          <li>Accès illimité à + de 100 000 profils de professeur(e)s</li><br>
          <li>Messagerie pour échanger avec les autres membres</li><br>
          <li>Profil certifié</li><br>
          <li>Voir qui a consulté votre profil</li>
        </ul>
        <a href="paiement1.php" class="button">Essayer</a>
      </div>
      
      
      <!-- Abonnement Mensuel -->
      <div class="pricing-plan">
        <div class="duration">1 mois</div>
        <h3>Abonnement Mensuel</h3>
        <div class="price">5,99€</div>
        <ul>
          <li>Accès illimité à + de 100 000 profils de professeur(e)s</li><br>
          <li>Messagerie pour échanger avec les autres membres</li><br>
          <li>Profil certifié</li><br>
          <li>Voir qui a consulté votre profil</li>
        </ul>
        <a href="paiement2.php" class="button">S'abonner</a>
      </div>

      <!-- Abonnement Trimestriel -->
      <div class="pricing-plan">
        <div class="duration">3 mois</div>
        <h3>Abonnement Trimestriel</h3>
        <div class="price">10,99€</div>
        <ul>
          <li>Accès illimité à + de 100 000 profils de professeur(e)s</li><br>
          <li>Messagerie pour échanger avec les autres membres</li><br>
          <li>Profil certifié</li><br>
          <li>Voir qui a consulté votre profil</li>
        </ul>
        <a href="paiement3.php" class="button">S'abonner</a>
      </div>

      <!-- Abonnement annuel -->
      <div class="pricing-plan">
        <div class="duration">1 an</div>
        <h3>Abonnement Annuel</h3>
        <div class="price">59,99€</div>
        <ul>
          <li>Accès illimité à + de 100 000 profils de professeur(e)s</li><br>
          <li>Messagerie pour échanger avec les autres membres</li><br>
          <li>Profil certifié</li><br>
          <li>Voir qui a consulté votre profil</li>
        </ul>
        <a href="paiement4.php" class="button">S'abonner</a>
      </div>
          
 
    </div>
  </div>
</body>
</html>
