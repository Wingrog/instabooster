<?php
// On se connecte à la base de donnée
require_once 'connexion_bdd.php';

// On récupère les fonctions
require_once 'function.php';

$id = $_GET['id'];
deleteImage($pdo, $id);
header('Location: mon-espace.php');
