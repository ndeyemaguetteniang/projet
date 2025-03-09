<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit();
}

require_once "connexion.php";   

if (!$con) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

$sql = "SELECT * FROM utilisateurs";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .wrapper {
            width: 1000px;
            margin: 0 auto;
     .header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

        }
        table tr td:last-child {
            width: 120px;
            
        }
        
        .action-icons a {
            text-decoration: none;
            color: #333;
            font-size: 10px;
            margin-right: 20px;
        }
        .action-icons {
            
    display: flex; 
    gap: 3px; 
        }

.view-icon, .edit-icon, .delete-icon {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
    text-align: center;
    font-weight: bold;
    color: white;
    text-decoration: none;
}

.view-icon {
    background-color: lightgreen; 
}

.edit-icon {
    background-color: orange; 
}

.delete-icon {
    background-color: yellow; 
}


.view-icon:hover {
    background-color: lightgreen;
}

.edit-icon:hover {
    background-color: darkorange;
}

.delete-icon:hover {
    background-color: yellow;
}
    </style>
</head>
<body>
    <div class="wrapper">
    <div class="header-container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 d-flex justify-content-between">
                    <a href="create.php" class="btn btn-success"><button class="btn btn-success">+ Ajouter</button></a>
                         <h2>Liste des utilisateurs</h2>
                        <a href="logout.php" class="btn btn-danger mb-3">Déconnexion</a>
                  </div>
                    </div>
                    <?php
                    // Vérifier si la requête a bien fonctionné
                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Id</th>";
                                        echo "<th>Nom</th>";
                                        echo "<th>Prénom</th>";
                                        echo "<th>Login</th>";
                                        echo "<th>Profil</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['nom'] . "</td>";
                                        echo "<td>" . $row['prenom'] . "</td>";
                                        echo "<td>" . $row['login'] . "</td>";
                                        echo "<td><img src='" . $row['profil'] . "' width='50' height='50'></td>";
                                        echo "<td class='action-icons'>";
                                        echo '<a href="read.php?id='. $row['id'] .'" class="view-icon">Read</a>';
                                        echo '<a href="update.php?id='. $row['id'] .'" class="edit-icon">Update</a>';
                                        echo '<a href="delete.php?id='. $row['id'] .'" class="delete-icon">Delete</a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            mysqli_free_result($result);
                        } else {
                            echo '<div class="alert alert-danger"><em>Pas d\'enregistrement trouvé.</em></div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger"><em>Erreur lors de la récupération des données.</em></div>';
                    }

                    // ici on ferme la connexion
                    mysqli_close($con);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>