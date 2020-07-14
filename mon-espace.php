    <?php
    require_once 'connexion_bdd.php';
    include('function.php');
    include('parts/head.php');
    include('parts/menu.php');

    $errors = [];

    session_start();

    if (!$_SESSION['login']) {
        header('Location: login.php');
    }

    $reponse = $pdo->query('SELECT * FROM photo');


    ?>

    <body>

        <h1 class="mt-5 text-center mb-5 text-danger">InstaBooster meilleur que Insta !</h1>
        <center><a class="btn btn-primary" title="Ajouter une image" href="add-image.php">Ajouter une image</a></center>
        <center><a class="mt-3 btn btn-danger" title="Se deconnecter" href="disconnect.php">Se déconnecter</a></center>
        <br><br>

        <div>
            <?php
            while ($data = $reponse->fetch()) {
            ?>
                <div class="container d-flex justify-content-center mt-5 text-center">
                    <div class="col-4 p-0 m-4 card" style="width: 22rem;">
                        <img class="card-img-top" src="<?php echo ('upload/image/' . $data['file_name']); ?>" alt="Une belle image"><br>
                        <h5 class="card-title">Lieu de publication : <?php echo ($data['lieu_publi']) ?></h5>
                        <p class="card-text">Le <?php echo ($data['date_publication']) ?></p>
                        <p class="card-text">Posté par <?php echo ($data['nom_prenom_utilisateur']) ?></p>
                        <a class="btn btn-success" title="detail de l'image" href="detail-image.php?id=<?php echo ($data['id']); ?>">Détail de l'image</a><br>
                        <a class="btn btn-danger" title="Supprimer" href="delete-image.php?id=<?php echo ($data['id']); ?>">Supprimer</a>

                    </div>

                </div>
        </div>

    <?php
            }
            $reponse->closeCursor(); ?>


    </body>

    </html>