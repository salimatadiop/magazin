<?php
//Base de donnée
if(!empty($_POST["send"])) {
	$nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
	$email = $_POST["email"];
	$motdepass1 = $_POST["motdepass1"];
    $motdepasse2 = $_POST["motdepasse2"];

	$connexion = mysqli_connect("localhost", "root", "", "magazin-salimata") or die("Erreur de connexion: " . mysqli_error($connexion));
	$result = mysqli_query($connexion, "INSERT INTO inscription (nom ,prenom,email,motdepass1,motdepasse2) VALUES ('" . $nom. "','" . $prenom. "', '" . $email. "','" . $motdepass1. "','" . $motdepasse2. "')");
	if($result){
		$db_msg = "Vos informations d'insciption sont enregistrées avec succés.";
		$type_db_msg = "success";
	}else{
		$db_msg = "Erreur lors de la tentative d'enregistrement de l'insription.";
		$type_db_msg = "error";
	}
	
}
// Initialiser la session
session_start();
// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if(!isset($_SESSION["email"])){
	header("Location: login.php");
	exit(); 
}
?>
<?php
require('session.php');
if (isset(	$_REQUEST['id'], 
	        $_REQUEST['nom'], 
			$_REQUEST['prenom'],
		 	$_REQUEST['email'],
			$_REQUEST['motdepass1'],
			$_REQUEST['motdepasse2'])){
	// récupérer le nom d'utilisateur et supprimer les antislashes ajoutés par le formulaire
	$id = stripslashes($_REQUEST['id']);
	$id = mysqli_real_escape_string($conn, $id); 

	$nom = stripslashes($_REQUEST['nom']);
	$nom = mysqli_real_escape_string($conn, $nom); 

	$prenom = stripslashes($_REQUEST['prenom']);
	$prenom = mysqli_real_escape_string($conn, $prenom); 
	// récupérer l'email et supprimer les antislashes ajoutés par le formulaire
	$email = stripslashes($_REQUEST['email']);
	$email = mysqli_real_escape_string($conn, $email);
	// récupérer le mot de passe et supprimer les antislashes ajoutés par le formulaire
	$motdepass1 = stripslashes($_REQUEST['motdepass1']);
	$motdepass1 = mysqli_real_escape_string($conn, $motdepass1);

	$motdepasse2 = stripslashes($_REQUEST['motdepasse2']);
	$motdepasse2 = mysqli_real_escape_string($conn, $motdepasse2);
	//requéte SQL + mot de passe crypté
    $query = "INSERT into `inscription` (id,nom,prenom, email, motdepass1, motdepasse2)
              VALUES ('$id','$nom', '$prenom','$email',' $motdepass1','$motdepasse2')";
	// Exécute la requête sur la base de données
    $res = mysqli_connect($conn, $query);
    if($res){
       echo "<div class='sucess'>
             <h3>Vous êtes inscrit avec succès.</h3>
             <p>Cliquez ici pour vous <a href='login.php'>connecter</a></p>
			 </div>";
    }
}else{
?>

<html>
	<head>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<div id="box">
		  <form id="form" method="post">
		    <h3>Formulaire d'insciption</h3>
		    <label>Nom: <span>*</span></label>
		    <input type="text" id="nom" name="nom" placeholder="Nom" require/>
            <label>Prénom: <span>*</span></label>
		    <input type="text" id="prenom" name="prenom" placeholder="Prénom" require/>
		    <label>Email: <span>*</span></label><span id="info" class="info"></span>
		    <input type="text" id="email" name="email" placeholder="Email" require/>
            <label>Mot de passe : <span>*</span></label>
		    <input type="password" id="motdepass1" name="motdepass1" placeholder="Mot de passe" require/>
            <label>cofirme le mot de passe : <span>*</span></label>
		    <input type="password" id="motdepasse2" name="motdepasse2" placeholder="confirme le mot de passe" require/> 
            <input type="submit" name="send" value="Envoyer le message"/>
			<p class="box-register">Déjà inscrit? <a href="login.php">Connectez-vous ici</a></p>

			
		  </form>
		  <?php } ?>
	    </div>
	</body>
</html>