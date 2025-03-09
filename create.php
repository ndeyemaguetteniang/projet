<?php
require_once "connexion.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $login = trim($_POST["login"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

    $dossier_images = "C:/Users/mague/OneDrive/Desktop/image/";

    if (!file_exists($dossier_images)) {
        mkdir($dossier_images, 0777, true);
    }

    if (isset($_FILES["profil"]) && $_FILES["profil"]["error"] === UPLOAD_ERR_OK) {
        $nom_fichier = basename($_FILES["profil"]["name"]);

        $extension = pathinfo($nom_fichier, PATHINFO_EXTENSION);
        $nom_fichier_unique = uniqid("profil_", true) . "." . $extension;

        $chemin_fichier = $dossier_images . $nom_fichier_unique;

        if (move_uploaded_file($_FILES["profil"]["tmp_name"], $chemin_fichier)) {
            
            $sql = "INSERT INTO utilisateurs (nom, prenom, login, password, profil) VALUES (?, ?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($con, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssss", $nom, $prenom, $login, $password, $chemin_fichier);

                if (mysqli_stmt_execute($stmt)) {
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Erreur lors de l'ajout de l'utilisateur.";
                }
                mysqli_stmt_close($stmt);
            }
        } else {
            echo "Erreur lors du déplacement du fichier.";
        }
    } else {
        echo "Erreur d'upload de l'image.";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Ajouter un utilisateur</h2>
        <form action="create.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Prénom</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Login</label>
                <input type="email" name="login" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Photo de profil</label>
                <input type="file" name="profil" class="form-control" required>
            </div>
            <input type="submit" class="btn btn-primary" value="Ajouter">
            <a href="index.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>
