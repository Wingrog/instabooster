<?php

//  VERIFICATION SI UN NOM D'UTILISATEUR EST DEJA EXISTANT DANS LA BASE DE DONNEE

function getUserByUsername($pdo, $pseudo)
{
    $res = $pdo->prepare('SELECT * FROM utilisateur WHERE pseudo = :pseudo');
    $res->execute(['pseudo' => $pseudo]);

    return $res->fetch();
}

//  VERIFICATION SI UN EMAIL EST DEJA EXISTANT DANS LA BASE DE DONNEE

function getMailByUsername($pdo, $email)
{
    $res = $pdo->prepare('SELECT * FROM utilisateur WHERE email = :email');
    $res->execute(['email' => $email]);

    return $res->fetch();
}

// FONCTION POUR VERIFIER LES INPUT DANS LE FORMULAIRE + VERIFICATION SI UN NOM D'UTILISATEUR ET E-MAIL EST DEJA EXISTANT

function validateFormRegister($pdo)
{
    $errors = [];

    if (getUserByUsername($pdo, $_POST['pseudo']) !== false) {
        $errors[] = "Impossible ce pseudo est déjà existant !";
    }

    if (getMailByUsername($pdo, $_POST['email']) !== false) {
        $errors[] = "Impossible cet email est déjà existant !";
    }

    // Control des INPUTS

    if (empty($_POST['pseudo'])) {
        $errors[] = "Veuillez renseigner un pseudo";
    }

    if (empty($_POST['nom'])) {
        $errors[] = "Veuillez renseigner un nom";
    }

    if (empty($_POST['prenom'])) {
        $errors[] = "Veuillez renseigner un prenom";
    }
    if (empty($_POST['password'])) {
        $errors[] = "Veuillez renseigner un mot de pass";
    }

    if (empty($_POST['email'])) {
        $errors[] = "Veuillez renseigner un e-mail";
    }

    return $errors;
}


// FONCTION POUR AJOUTER UN UTILISATEUR EN BASE DE DONNEE

function registerUser($pdo)
{

    $res = $pdo->prepare(
        'INSERT INTO utilisateur (pseudo, email, prenom, nom, password)
    VALUES (:pseudo, :email, :prenom, :nom, :password)'
    );

    $res->execute([
        ':pseudo' => $_POST['pseudo'],
        ':nom' => $_POST['nom'],
        ':prenom' => $_POST['prenom'],
        ':email' => $_POST['email'],
        ':password' => md5($_POST['password'])
    ]);
}




// FONCTION DE VERIFICATION POUR LE FORMULAIRE POUR SE CONNECTER


function validateFormLogin()
{
    $errors = [];

    // Control des INPUTS

    if (empty($_POST['pseudo'])) {
        $errors[] = "Veuillez renseigner un login";
    }

    if (empty($_POST['password'])) {
        $errors[] = "Veuillez renseigner un mot de pass";
    }

    return $errors;
}



// FONCTION QUI LOG L'UTILISATEUR SUR LE SITE ET VERIFIE SI LE LOGIN ET LE MOT DE PASS EST CORRECT

function connectUser($pdo)
{
    $errors = [];

    $res = $pdo->prepare(
        'SELECT * FROM utilisateur WHERE pseudo = :pseudo OR email = :pseudo AND password = :password'
    );
    $res->execute([
        'pseudo' => $_POST['pseudo'],
        'password' => md5($_POST['password'])
    ]);
    $res = $res->fetch();
    if (!$res) {
        $errors[] = 'Login ou Mot de pass incorrect !';
    } else {
        session_start();
        $_SESSION['login'] = $res;
        header('Location: mon-espace.php');
    }
    return $errors;
}





// TABLEAU POUR LE SELECT POUR LES DROITS DE L'IMAGE

function getAutorisation()
{
    return ['Publique', 'Prive'];
}



// FONCTION LANCEE A LA VALIDATION DU FORMULAIRE D'AJOUT D'UNE ANNONCE D'IMAGE.

function validateAddImageForm()
{

    // On déclare un tableau d'erreurs vide.
    $errors = [];
    // On déclare une variable vide.
    $imageURL = '';

    // On vérifie si une image est bien présente.
    if ($_FILES['file_name']['size'] == 0) {
        $errors[] = "Veuillez ajouter une image";
    }

    // On vérifie si l'image est bien en .jpg ou en .png
    if ($_FILES['file_name']['type'] === 'image/png' || $_FILES['file_name']['type'] === 'image/jpeg') {
        // On vérifie le poids de l'image
        if ($_FILES['file_name']['size'] < 800000000000) {
            $extension = explode('/', $_FILES['file_name']['type'])[1];
            $imageURL = uniqid() . '.' . $extension;
            move_uploaded_file($_FILES['file_name']['tmp_name'], 'upload/image/' . $imageURL);
        } else {
            $errors[] = 'Erreur, fichier trop lourd';
        }
    } else {
        $errors[] = 'Erreur, seuls les png et jpg sont acceptés';
    }

    // Vérifications des Input du formulaire
    if (empty($_POST['date_publication'])) {
        $errors[] = 'Erreur, entrez une date de publication';
    }

    if (empty($_POST['lieu_publi'])) {
        $errors[] = 'Erreur, entrez un lieu de publication';
    }


    return ['errors' => $errors, 'file_name' => $imageURL];
}




// FONCTION POUR AJOUTER UNE ANNONCE IMAGE.

function addBdd($pdo, $imageURL)
{
    // On prepare la requête SQL à envoyer
    $req = $pdo->prepare(
        'INSERT INTO photo (file_name, lieu_publi, date_publication, nom_prenom_utilisateur) 
        VALUES (:file_name, :lieu_publi, :date_publication, :nom_prenom_utilisateur)'
    );

    // On envoie la requête avec les infos
    $req->execute([
        'file_name' => $imageURL,
        'lieu_publi' => $_POST['lieu_publi'],
        'date_publication' => $_POST['date_publication'],
        'nom_prenom_utilisateur' => $_POST['nom_prenom_utilisateur']
    ]);
}





// SUPPRIMER UNE IMAGE SELON SON ID.


function deleteImage($pdo, $id)
{
    $res = $pdo->prepare('DELETE FROM photo WHERE id = :id');
    $res->execute(['id' => $id]);
}
