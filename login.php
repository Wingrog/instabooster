    <?php
    require_once 'connexion_bdd.php';
    include('function.php');
    include('parts/head.php');
    include('parts/menu.php');

    $errors = [];

    session_start();


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = validateFormLogin();

        // Si il n'y a pas d'erreurs dans le tableau, le formulaire est validé
        if (count($errors) == 0) {
            $errors = connectUser($pdo);
            if (count($errors) == 0) {
                header('Location: mon-espace.php');
            }
        }
    }

    ?>

    <body>

        <h1 class="text-center ml-3 mt-5">Se connecter</h1><br>

        <!-- Création du formulaire -->

        <form class="form-control" method="post" action="login.php" enctype="multipart/form-data">
            <label>Login ou E-mail</label>
            <input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Login ou E-mail">
            <label>Mot de pass</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Mot de pass"><br>
            <input type="submit" value="Se connecter">

            <?php
            if (count($errors) != 0) {
                echo ('<h2>Erreurs lors de la dernière soumission du formulaire : </h2>');
                foreach ($errors as $error) {
                    echo ('<div class="error">' . $error . '</div>');
                }
            }
            ?>
            <br><br><a class="btn btn-success" href="register.php">Pas de compte ? Créé en un !</a>
        </form>


    </body>

    </html>