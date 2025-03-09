<?php
session_start();
require_once "connexion.php";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit();
}

$login = $password = "";
$login_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["login"]))) {
        $login_err = "Veuillez entrer votre login.";
    } else {
        $login = trim($_POST["login"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Veuillez entrer votre mot de passe.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($login_err) && empty($password_err)) {
        $sql = "SELECT id, login, password FROM utilisateurs WHERE login = ?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $login);

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $hashed_password = $row["password"];

                    if (password_verify($password, $hashed_password)) {
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $row["id"];
                        $_SESSION["login"] = $row["login"];

                        header("location: index.php");
                    } else {
                        $password_err = "Mot de passe incorrect.";
                    }
                } else {
                    $login_err = "Aucun compte trouvé avec ce login.";
                }
            } else {
                echo "Erreur de connexion.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .login-container {
            width: 400px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card shadow-lg">
            <div class="card-body">
                <h2 class="text-center mb-4">Connexion</h2>
                <form action="login.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Login</label>
                        <input type="text" name="login" class="form-control <?php echo (!empty($login_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $login; ?>">
                        <div class="invalid-feedback"><?php echo $login_err; ?></div>
                    </div>    
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                        <div class="invalid-feedback"><?php echo $password_err; ?></div>
                    </div>
                    <div class="d-grid">
                        <input type="submit" class="btn btn-primary" value="Connexion">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
