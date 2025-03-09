<?php
require_once "connexion.php";

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id = $_GET["id"];

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = trim($_POST["nom"] ?? "");
        $prenom = trim($_POST["prenom"] ?? "");
        $login = trim($_POST["login"] ?? "");

        if (empty($nom) || empty($prenom) || empty($login)) {
            echo "Tous les champs sont obligatoires.";
            exit();
        }
        $dossier_images = "images/";
        if (!is_dir($dossier_images)) {
            mkdir($dossier_images, 0777, true);
        }

        $stmt = null; 

        if (!empty($_FILES["profil"]["name"])) {
            $nom_fichier = basename($_FILES["profil"]["name"]);
            $extension = pathinfo($nom_fichier, PATHINFO_EXTENSION);
            $nom_fichier_unique = uniqid("profil_", true) . "." . $extension;
            $chemin_fichier = $dossier_images . $nom_fichier_unique;

            if (move_uploaded_file($_FILES["profil"]["tmp_name"], $chemin_fichier)) {
                
                $sql = "UPDATE utilisateurs SET nom=?, prenom=?, login=?, profil=? WHERE id=?";
                if ($stmt = mysqli_prepare($con, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssssi", $nom, $prenom, $login, $chemin_fichier, $id);
                }
            } else {
                echo "Erreur d'upload.";
                exit();
            }
        } else {
    
            $sql = "UPDATE utilisateurs SET nom=?, prenom=?, login=? WHERE id=?";
            if ($stmt = mysqli_prepare($con, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssi", $nom, $prenom, $login, $id);
            }
        }

        if ($stmt && mysqli_stmt_execute($stmt)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Erreur de mise à jour.";
        }
    }

    // Récupérer les infos de l'utilisateur
    $sql = "SELECT * FROM utilisateurs WHERE id = ?";
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_array($result)) {
            $nom = $row["nom"];
            $prenom = $row["prenom"];
            $login = $row["login"];
            $profil = $row["profil"];
        } else {
            echo "Utilisateur non trouvé.";
            exit();
        }
    }
} else {
    echo "ID manquant.";
    exit();
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Modifier un utilisateur</h2>
        <form action="update.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" value="<?php echo htmlspecialchars($nom); ?>" required>
            </div>
            <div class="mb-3">
                <label>Prénom</label>
                <input type="text" name="prenom" class="form-control" value="<?php echo htmlspecialchars($prenom); ?>" required>
            </div>
            <div class="mb-3">
                <label>Login</label>
                <input type="email" name="login" class="form-control" value="<?php echo htmlspecialchars($login); ?>" required>
            </div>
            <div class="mb-3">
                <label>Photo de profil (optionnel)</label>
                <input type="file" name="profil" class="form-control">
                <?php if (!empty($profil)) : ?>
                    <p>Image actuelle :</p>
                    <img src="<?php echo htmlspecialchars($profil); ?>" alt="Profil" width="100">
                <?php endif; ?>
            </div>
            <input type="submit" class="btn btn-primary" value="Modifier">
            <a href="index.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>
