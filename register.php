<?php

require_once("connexion_bdd.php");
require_once("function.php");

include('parts/head.php');
include('parts/menu.php');



// On déclare un tableau d'erreurs vide
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateFormRegister($pdo);

    // Si il n'y a pas d'erreurs dans le tableau, le formulaire est validé
    if (count($errors) == 0) {
        registerUser($pdo);
        header('Location: login.php');
    }
}

?>

<body>

    <h1 class="text-center ml-3 mt-5">Créer un compte</h1><br>

    <!-- Création du formulaire -->

    <form class="form-control" method="post" action="register.php" enctype="multipart/form-data">
        <label>Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Indique ton pseudo">
        <label>Nom</label>
        <input type="text" name="nom" id="nom" class="form-control" placeholder="Indique ton nom">
        <label>Prenom</label>
        <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Indique ton prenom">
        <label>E-mail</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Indique ton e-mail">
        <label>Mot de pass</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Indique un mot de pass"><br>
        <input type="submit" value="Créer mon compte">

        <?php
        if (count($errors) != 0) {
            echo (' <h2>Erreurs lors de la dernière soumission du formulaire : </h2>');
            foreach ($errors as $error) {
                echo ('<div class="error">' . $error . '</div>');
            }
        }
        ?>
    </form>
</body>

</html>