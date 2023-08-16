<?php
// Inclure le fichier
require_once "session.php";
 
// Definir les variables
$nomproduit = $nombrestock = $prix = "";
$nomproduit_err = $nombrestock_err = $prix_err = "";
 
// verifier la valeur id dans le post pour la mise à jour
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // recuperation du champ chaché
    $id = $_POST["id"];
    
    // Validate nom de produit
    $input_nomproduit = trim($_POST["nomproduit"]);
    if(empty($input_nomproduit)){
        $name_err = "Veillez entrez un nom de produit.";
    } elseif(!filter_var($input_nomproduit, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nomproduit_err = "Veillez entrez a valid nom de produit.";
    } else{
        $nomproduit = $input_nomproduit;
    }
    
    // Validate nombre stock
    $input_nombrestock = trim($_POST["nombrestock"]);
    if(empty($input_nombrestock)){
        $nombrestock_err = "Veillez entrez une nombrestock.";     
    } else{
        $nombrestock = $input_nombrestock;
    }
    
    // Validate prix
    $input_prix = trim($_POST["prix"]);
    if(empty($input_prix)){
        $prix_err = "Veillez entrez l'prix.";     
    } elseif(!ctype_digit($input_prix)){
        $prix_err = "Veillez entrez une valeur positive.";
    } else{
        $prix = $input_prix;
    }
    
    // verifier les erreurs avant modification
    if(empty($nomproduit_err) && empty($nombrestock_err) && empty($prix_err)){
        // Prepare an update statement
        $sql = "UPDATE produit SET nomproduit=?, nombrestock=?, prix=? WHERE id=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind les variables
            mysqli_stmt_bind_param($stmt, "sssi", $param_nomproduit, $param_nombrestock, $param_prix, $param_id);
            
            // Set parameters
            $param_nomproduit = $nomproduit;
            $param_nombrestock = $nombrestock;
            $param_prix = $prix;
            $param_id = $id;
            
            // executer
            if(mysqli_stmt_execute($stmt)){
                // enregistremnt modifié, retourne
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
    mysqli_close($conn);
} else{
    // si il existe un paramettre id
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // recupere URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare la requete
        $sql = "SELECT * FROM produit WHERE id = ?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind les variables
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* recupere l'enregistremnt */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // recupere les champs
                    $nomproduit = $row["nomproduit"];
                    $nombrestock = $row["nombrestock"];
                    $prix = $row["prix"];
                } else{
                    // pas de id parametter valid, retourne erreur
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
    }  else{
        // pas de id parametter valid, retourne erreur
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'enregistremnt</title>
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
                    <h2 class="mt-5">Mise à jour de produit</h2>
                    <p>Modifier les champs et enregistrer</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="nomproduit" class="form-control <?php echo (!empty($nomproduit_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nomproduit; ?>">
                            <span class="invalid-feedback"><?php echo $nomproduit_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>le stock</label>
                            <textarea name="nombrestock" class="form-control <?php echo (!empty($nombrestock_err)) ? 'is-invalid' : ''; ?>"><?php echo $nombrestock; ?></textarea>
                            <span class="invalid-feedback"><?php echo $nombrestock_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Prix</label>
                            <input type="text" name="prix" class="form-control <?php echo (!empty($prix_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $prix; ?>">
                            <span class="invalid-feedback"><?php echo $prix_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enregistrer">
                        <a href="connexion.php" class="btn btn-secondary ml-2">Annuler</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
