<?php
// Démarrer la session
session_start();

// Inclure le fichier de base de données
include '../include/database.php';

// Récupérer l'ID de l'utilisateur connecté depuis l'URL
$user_id = $_GET['user_id'];

// Récupérer les informations de l'utilisateur
$query_user = $db->prepare("SELECT Nom, Prenom, photo FROM utilisateur WHERE id = :id");
$query_user->execute(array(':id' => $user_id));
$user = $query_user->fetch();

$filename = "../" . $user["photo"];

// Récupérer les contacts ajoutés par l'utilisateur depuis la base de données
$query = $db->prepare("SELECT utilisateur.id, Nom, Prenom, photo FROM utilisateur INNER JOIN messagerie ON utilisateur.id = messagerie.id2 WHERE messagerie.id1 = :user_id ORDER BY Nom, Prenom");
$query->execute(array(':user_id' => $user_id));
$contacts = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Messagerie - RencontreProfs</title>
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>
  <script src="https://use.typekit.net/hoy3lrg.js"></script>
  <script>try{Typekit.load({ async: true });}catch(e){}</script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
  <link rel="stylesheet" href="../css/messagerie.css">
  <link rel="stylesheet" href="../css/retour.css">
</head>
<body>
<div id="frame">
  <div id="sidepanel">
    <div id="profile">
      <div class="wrap">
        <?php echo '<img src="' . $filename . '" class="online" width="40" height="40" alt="" />'; ?>
        <p><?php echo $user['Prenom'] . ' ' . $user['Nom']; ?></p>
        <i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
        <div id="status-options">
          <ul>
            <li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>
            <li id="status-away"><span class="status-circle"></span> <p>Away</p></li>
            <li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>
            <li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>
          </ul>
        </div>
        <div id="expanded">
          <label for="facebook"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
          <input name="facebook" type="text" value="Couscous" />
          <label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
          <input name="twitter" type="text" value="couscous" />
          <label for="instagram"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
          <input name="instagram" type="text" value="couscous" />
        </div>
      </div>
    </div>
    <div id="search">
      <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
      <input type="text" id="search-input" placeholder="Rechercher des personnes..." onkeyup="filterContacts()" />
    </div>
    <div id="contacts">
        <ul id="contacts-list">
        <?php foreach ($contacts as $contact): ?>
            <li class="contact">
                <div class="wrap">
                    <span class="contact-status online"></span>
                    <?php 
                    // Chemin de la photo du contact
                    $contact_photo = "../" . $contact['photo'];
                    echo '<a href="messagerie.php?user_id=' . $user_id . '&user2_id=' . $contact['id'] . '">';
                    echo '<img src="' . $contact_photo . '" class="online" width="40" height="40" alt="" />';
                    echo '</a>';
                    ?>
                    <div class="meta">
                        <p class="name"><?php echo $contact['Prenom'] . ' ' . $contact['Nom']; ?></p>
                        <p class="preview">Envoyez un message à <?php echo $contact['Prenom']; ?></p>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div id="bottom-bar">
    <button id="addcontact" onclick="window.location.href='demandami.php'"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Ajouter</span></button>
    <button id="block" onclick="window.location.href='block.php'"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Paramètre</span></button>
</div>
</div>
<div class="content">
    <div class="contact-profile">
      <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
      <p>Harvey</p>
      <div class="social-media">
        <i class="fa fa-facebook" aria-hidden="true"></i>
        <i class="fa fa-twitter" aria-hidden="true"></i>
         <i class="fa fa-instagram" aria-hidden="true"></i>
      </div>
    </div>
    <div class="messages">
      <ul>
        <li class="sent">
          <img src="https://i.pinimg.com/736x/7a/f0/04/7af004703ee797756ba58c0b186fdca9.jpg" alt="" />
          <p>T'es moche</p>
        </li>
        <li class="replies">
          <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
          <p>Tu es méchant.</p>
        </li>
        <li class="replies">
          <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
          <p>Excuse-toi !</p>
        </li>
        <li class="sent">
          <img src="https://i.pinimg.com/736x/7a/f0/04/7af004703ee797756ba58c0b186fdca9.jpg" alt="" />
          <p>Sans façon !</p>
        </li>
        <li class="replies">
          <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
          <p>J'aime le poulet.</p>
        </li>
        <li class="replies">
          <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
          <p>LMAO</p>
        </li>
        <li class="sent">
          <img src="https://i.pinimg.com/736x/7a/f0/04/7af004703ee797756ba58c0b186fdca9.jpg" alt="" />
          <p>Tu aimes le chou-fleur ?</p>
        </li>
        <li class="replies">
          <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
          <p>Non</p>
        </li>
      </ul>
    </div>
    <div class="message-input">
      <div class="wrap">
      <input type="text" placeholder="Écrivez votre message..." />
      <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
      <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
      </div>
    </div>
  </div>
</div>
<div>
  <!-- Bouton de retour -->
  <button class="back-button" onclick="window.location.href = '../menuabonne.php';">
    <i class="fa fa-arrow-left"></i> Retour
  </button>  
</div>

<script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
<script>
// Fonction de filtrage des contacts
function filterContacts() {
  var input, filter, ul, li, a, i, txtValue;
  input = document.getElementById('search-input');
  filter = input.value.toLowerCase();
  ul = document.getElementById("contacts-list");
  li = ul.getElementsByTagName('li');

  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByClassName("name")[0];
    txtValue = a.textContent || a.innerText;
    if (txtValue.toLowerCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
}
</script>
</body>
</html>
