<?php
// Inclure le fichier config
require_once "session.php";
 
// Definir les variables
$nomproduit = $nombrestock = $prix = "";
$nomproduit_err = $nombrestock_err = $prix_err = "";
 
// Traitement
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate nomproduit
    $input_nomproduit = trim($_POST["nomproduit"]);
    if(empty($input_nomproduit)){
        $nomproduit_err = "Veillez entrez un nom produit.";
    } elseif(!filter_var($input_nomproduit, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nomproduit_err = "Veillez entrez a valid nomproduit.";
    } else{
        $nomproduit = $input_nomproduit;
    }
    
    // Validate nombrestock
    $input_nombrestock = trim($_POST["nombrestock"]);
    if(empty($input_nombrestock)){
        $ecole_err = "Veillez entrez une nombre stock.";     
    } else{
        $nombrestock = $input_nombrestock;
    }
    
    // Validate prix
    $input_prix = trim($_POST["prix"]);
    if(empty($input_prix)){
        $prix_err = "Veillez entrez le prix.";     
    } elseif(!ctype_digit($input_prix)){
        $prix_err = "Veillez entrez une valeur positive.";
    } else{
        $prix = $input_prix;
    }
    
    // verifiez les erreurs avant enregistrement
    
    if(empty($nomproduit_err) && empty($nombrestock_err) && empty($prix_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO produit (nomproduit, nombrestock, prix) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind les variables à la requette preparée
            mysqli_stmt_bind_param($stmt, "ssd", $param_nomproduit, $param_nombrestock, $param_prix);
            
            // Set parameters
            $param_nomproduit = $nomproduit;
            $param_nombrestock = $nombrestock;
            $param_prix= $prix;
            
            // executer la requette
            if(mysqli_stmt_execute($stmt)){
                // opération effectuée, retour
                header("location: connexion.php");
                exit();
            } else{
                echo "Oops! une erreur est survenue.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Ajouter une produit</h2>
                    <p>Remplir le formulaire pour enregistrer des produits dans la base de données</p>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>nomproduit</label>
                            <input type="text" name="nomproduit" class="form-control <?php echo (!empty($nomproduit_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nomproduit; ?>">
                            <span class="invalid-feedback"><?php echo $nomproduit_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Nombre de stock</label>
                            <textarea name="nombrestock" class="form-control <?php echo (!empty($nombrestock_err)) ? 'is-invalid' : ''; ?>"><?php echo $nombrestock; ?></textarea>
                            <span class="invalid-feedback"><?php echo $nombrestock_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Prix</label>
                            <input type="number" name="prix" class="form-control <?php echo (!empty($prix_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prix; ?>">
                            <span class="invalid-feedback"><?php echo $prix_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="connexion.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>