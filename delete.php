<?php
require_once "connexion.php";

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);

    // Vérifier si le formulaire de confirmation a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //  requête de suppression
        $sql = "DELETE FROM utilisateurs WHERE id = ?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                // Redirection après suppression
                header("Location: index.php");
                exit();
            } else {
                echo "Erreur lors de la suppression.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($con);
} else {
    echo "ID utilisateur manquant.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-danger">Supprimer un utilisateur</h2>
        <p>Voulez-vous vraiment supprimer cet utilisateur ? Cette action est irréversible.</p>
        <form action="delete.php?id=<?php echo $id; ?>" method="post">
            <input type="submit" class="btn btn-danger" value="Oui, supprimer">
            <a href="index.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>