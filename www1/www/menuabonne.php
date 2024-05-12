<?php
session_start();
?>

<?php
// Inclure le fichier de base de données
include 'include/database.php';

// Récupérer l'ID de l'utilisateur connecté depuis la session
$user_id = $_SESSION['user']['id'];

// Récupérer la valeur du champ "vua" de l'utilisateur depuis la base de données
$query = $db->prepare("SELECT vua FROM utilisateur WHERE id = :user_id");
$query->execute(array(':user_id' => $user_id));
$user = $query->fetch();

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

              <a href="gestionadmin.php">Gestion Admin</a>
              <a href="listesignalement.php">Signalement</a>
            <?php endif; ?>
            <?php if ($is_subscribed): ?>

              <a href="messagerie.php">Messagerie</a>
              <a href="profile.php">Consultation du compte</a>
            
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
</body>

  <script src="js/script.js"></script>
  <script>
    // Code JavaScript pour la recherche en temps réel
    const searchInput = document.getElementById('site-search');
    const searchResults = document.getElementById('search-results');

    searchInput.addEventListener('input', function() {
      const searchTerm = this.value.trim();

      if (searchTerm === '') {
        searchResults.innerHTML = '';
        return;
      }

      fetch('search.php?search=' + searchTerm)
        .then(response => response.json())
        .then(data => {
          let html = '';

          if (data.length > 0) {
            data.forEach(user => {
              html += `<p><a href="profile.php?id=${user.id}">${user.prenom} ${user.nom}</a></p>`;
            });
          } else {
            html = '<p>Aucun résultat trouvé</p>';
          }

          searchResults.innerHTML = html;
        })
        .catch(error => {
          console.error('Error fetching search results:', error);
        });
    });
  </script>
</body>

</html>