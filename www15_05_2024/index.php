


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RencontreProfs</title>
  <link rel="stylesheet" href="css/acceuil.css">
</head>

<body>

  <header class="header">
    <div class="container">
      <h1 class="logo">RencontreProfs</h1>
      <div class="search-bar">
        <input type="search" id="site-search" name="q" placeholder="Rechercher des professeurs...">
        <div id="search-results" class="search-results"></div>
      </div>
      <nav>
        <ul class="nav-links">
          <li><a href="index.php">Accueil</a></li>
          <li><a href="pub.php">Premium</a></li>
          <li><a href="connexion.php">Connexion</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="hero">
    <div class="container">
      <h2 class="hero-title">Rencontrez des professionnels de l'informatique</h2>
      <p class="hero-text">Trouvez des collègues passionnés et partagez vos expériences</p>
      <a href="choixdeconnexion.php" class="btn">S'inscrire</a>
    </div>
  </section>

  <section class="features">
    <div class="container">
      <h2 class="section-title">Pourquoi choisir RencontreProfs ?</h2>
      <div class="feature">
        <h3 class="feature-title">Réseau Professionnel</h3>
        <p class="feature-text">Evitez les futures disputes de couples sur les meilleurs langages de programmations.</p>
      </div>
      <div class="feature">
        <h3 class="feature-title">Partage de bons moments</h3>
        <p class="feature-text">Partagez vos passions, découvrez celles des autres.</p>
      </div>
      <div class="feature">
        <h3 class="feature-title">Sécurisé et Privé</h3>
        <p class="feature-text">Vos données sont sécurisées et vous avez le contrôle total de votre vie privée.</p>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <p>&copy; 2024 RencontreProfs. Tous droits réservés.</p>
    </div>
  </footer>

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
              html += `<p><a href="voir.php?id=${user.id}">${user.prenom} ${user.nom}</a></p>`;
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
