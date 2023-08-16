<?php
	// Initialiser la session
	session_start();
	// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
	if(!isset($_SESSION["email"])){
		header("Location: login.php");
		exit(); 
	}
?>
<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" href="style.css" />
	</head>
	<body>
	<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        .wrapper{
            width: 700px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
   
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 d-flex justify-content-between">
                        <h2 class="pull-left">Liste des produits</h2>
                        <a href="creproduit.php" class="btn btn-success"><i class="bi bi-plus"></i> Ajouter</a>
                    </div>
                    <?php

                    // Inclure le fichier config
                    require_once "session.php";
				
				    // $sql ="INSERT INTO produit (nomproduit ,nombrestock,prix) VALUES (CHEMISE LONG MACHE,4 ,8000)";
					// $sql ="INSERT INTO produit (nomproduit ,nombrestock,prix) VALUES ('CHEMISE',8 ,6000)";
					// $sql ="INSERT INTO produit (nomproduit ,nombrestock,prix) VALUES ('CHEMISE COURTE MASSE',2 ,4000)";
					// $sql ="INSERT INTO produit (nomproduit ,nombrestock,prix) VALUES ('ROBE ',6 ,2000)";
					// $sql ="INSERT INTO produit (nomproduit ,nombrestock,prix) VALUES ('ROBE POUR BB',4 ,2000)";
					// $sql ="INSERT INTO produit (nomproduit ,nombrestock,prix) VALUES ('ROBE POUR ADULTE',3,7000)";
					// $sql ="INSERT INTO produit (nomproduit ,nombrestock,prix) VALUES ('PENTALON',5 ,5000)";

                    // select query execution
                    $sql = "SELECT * FROM produit";
                    if($result = mysqli_query($conn, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Nom du produit</th>";
                                        echo "<th>le stock</th>";
                                        echo "<th>prix</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['nomproduit'] . "</td>";
                                        echo "<td>" . $row['nombrestock'] . "</td>";
                                        echo "<td>" . $row['prix'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['id'] .'" class="me-3" ><span class="bi bi-eye"></span></a>';
                                            echo '<a href="update.php?id='. $row['id'] .'" class="me-3" ><span class="bi bi-pencil"></span></a>';
                                            echo '<a href="delete.php?id='. $row['id'] .'" ><span class="bi bi-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>Pas d\'enregistrement</em></div>';
                        }
                    } else{
                        echo "Oops! Une erreur est survenue";
                    }
							
                    // Fermer connection
                    mysqli_close($conn);
                    ?>
                    		<a href="deconnexion.php">Déconnexion</a>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
