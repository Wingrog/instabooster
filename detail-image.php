<?php

require_once("connexion_bdd.php");
require_once("function.php");

include('parts/head.php');
include('parts/menu.php');


// On va afficher la planete selon son ID
$res = $pdo->prepare('SELECT * FROM photo WHERE id = :id');
$res->execute(['id' => $_GET['id']]);

// Variable qui affichera les données
$fetchRes = $res->fetch();


?>

<body>

    <div class="container d-flex justify-content-center mt-5">
        <div class="col-4 p-0 m-4 card" style="width: 22rem;">
            <img class="card-img-top" src="<?php echo ('upload/image/' . $fetchRes['file_name']); ?>" alt="Une belle photo">
            <div class="card-body">
                <h5 class="card-title">Date de publication : <?php echo ($fetchRes['date_publication']) ?></h5>
                <p class="card-title">Lieu de la publication : <?php echo ($fetchRes['lieu_publi']) ?></p>
                <p class="card-text">Posté par : <?php echo ($fetchRes['nom_prenom_utilisateur']) ?></p>
            </div>
        </div>
    </div>

    <center><a class="btn btn-success" href="index.php">Retour</a></center>



    <?php
    $res->closeCursor();
    ?>

</body>

</html>