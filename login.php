<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
<?php
require('session.php');
session_start();

if (isset($_POST['email'])){
	$email = stripslashes($_REQUEST['email']);
	$email = mysqli_real_escape_string($conn, $email);
	$motdepass1 = stripslashes($_REQUEST['motdepass1']);
	$motdepass1 = mysqli_real_escape_string($conn, $motdepass1);
    $query = "SELECT * FROM `inscription` WHERE email='$email' and motdepass1 ='$motdepass1'";
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn,$query));
	$rows = mysqli_num_rows($result);
	if($rows==1){
	    $_SESSION['email'] = $email;
	    header("Location: connexion.php");
	}else{
		$message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
	}
}
?>
    <div id="box">
		<form id="form" method="post"  name="login">
            <h3>Formulaire de connexion</h3>
            <label>Email: <span>*</span></label><span id="info" class="info"></span>
		    <input type="text" id="email" name="email" placeholder="Email" require/>
            <label>Mot de passe : <span>*</span></label>
		    <input type="password" id="motdepass1" name="motdepass1" placeholder="Mot de passe" require/>
            <input type="submit" value="Connexion " name="submit" class="box-button">
            <p class="box-register">Vous êtes nouveau ici? <a href="inscription.php">S'inscrire</a></p>
            <?php if (! empty($message)) { ?>
                <p class="errorMessage"><?php echo $message; ?></p>
            <?php } ?>
        </From>
    </div>
</body>
</html>