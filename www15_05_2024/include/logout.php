<?php
session_start();
session_destroy();
header("Location: ../index.php"); // Redirection vers la page d'accueil après déconnexion
exit();
?>