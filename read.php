<?php
// Verifiez si le paramettre id existe
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Inclure le fichier config
    require_once "session.php";
    
    // Preparer la requete
    $sql = "SELECT * FROM produit WHERE id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind les variables
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute la requette
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* recuperer l'enregistrement */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // recuperer les champs
                $nomproduit = $row["nomproduit"];
                $nombrestock = $row["nombrestock"];
                $prix= $row["prix"];
            } else{
                // Si pas de id correct retourne la page d'erreur
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! une erreur est survenue.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($conn);
} else{
    // Si pas de id correct retourne la page d'erreur
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voir l'enregistrement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .wrapper{
            width: 700px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">Voir l'enregistremnt</h1>
                    <div class="form-group">
                        <label>Nom produit </label>
                        <p><b><?php echo $row["nomproduit"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>le stock</label>
                        <p><b><?php echo $row["nombrestock"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Prix</label>
                        <p><b><?php echo $row["prix"]; ?></b> ans</p>
                    </div>
                    <p><a href="connexion.php" class="btn btn-primary">Retour</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
