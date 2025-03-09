<?php
// Inclure la connexion à la base de données
require_once "connexion.php";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);

    $sql = "SELECT * FROM utilisateurs WHERE id = ?";
    if ($stmt = mysqli_prepare($con, $sql)) {

        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $nom = $row["nom"];
                $prenom = $row["prenom"];
                $login = $row["login"];
            } else {
                echo "Aucun utilisateur trouvé.";
                exit();
            }
        } else {
            echo "Erreur lors de l'exécution de la requête.";
            exit();
        }
    }
    
    // Fermer la connexion
    mysqli_stmt_close($stmt);
} else {
    echo "ID utilisateur manquant.";
    exit();
}
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .wrapper {
            width: 50%;
            margin: 50px auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            display: block;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2 class="text-center">Détails de l'utilisateur</h2>
        <hr>
        <table class="table">
            <tr><th>Nom :</th><td><?php echo $nom; ?></td></tr>
            <tr><th>Prénom :</th><td><?php echo $prenom; ?></td></tr>
            <tr><th>Login :</th><td><?php echo $login; ?></td></tr>
        </table>
        <div class="text-center">
            <a href="index.php" class="btn btn-primary">Retour</a>
        </div>
    </div>
</body>
</html>
