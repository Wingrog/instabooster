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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $returnValidation = validateAddImageForm();
        $errors = $returnValidation['errors'];
        $image = $returnValidation['file_name'];
        // Si il n'y a pas d'erreurs dans le tableau, le formulaire est validé
        if (count($errors) == 0) {
            addBdd($pdo, $image);
            header('Location: mon-espace.php');
        }
    }

    ?>

    <body>

        <h1>Ajouter une image</h1>

        <!-- Création du formulaire -->

        <form class="form-control" method="post" action="add-image.php" enctype="multipart/form-data">
            <label>Date de publication</label>
            <input type="date" name="date_publication" id="date_publication" class="form-control" placeholder="Date de la publication">
            <label>Lieu de location</label>
            <input type="text" name="lieu_publi" id="lieu_publi" class="form-control" placeholder="Lieu de la publication">
            <label>Posté par</label>
            <input type="text" name="nom_prenom_utilisateur" id="nom_prenom_utilisateur" class="form-control" placeholder="Posté par">
            <label>Visibilitée</label>
            <select name="visible" id="visible" class="form-control" placeholder="Visibilitee">
                <?php
                foreach (getAutorisation() as $item) {
                    echo ('<option value="' . $item . '">' . $item . '</option>');
                }
                ?>
            </select>
            <label>Image</label>
            <input type="file" name="file_name"><br><br>
            <input type="submit" value="Envoyer">
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