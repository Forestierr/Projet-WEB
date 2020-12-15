<?php 
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projet web;charset=utf8', 'root', '');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
} 
$error = NULL;	
if (isset($_COOKIE['pseudo']) AND isset($_COOKIE['pass'])) 
{
	echo "cookie reussie";
	header('Location: membres_espace.php');
}
else
{
	if (isset($_POST['pseudo'])) 
	{
		// On rend inoffensives les balises HTML 
		$_POST['pseudo'] = htmlspecialchars($_POST['pseudo']); 
		$_POST['pass'] = htmlspecialchars($_POST['pass']); 
			$pseudo = $_POST['pseudo'];
		//  Récupération de l'utilisateur et de son pass hashé
		$req = $bdd->prepare('SELECT pseudo, pass, email FROM membres WHERE pseudo = :pseudo');
		$req->execute(array('pseudo'=>$_POST['pseudo']));
		$resultat = $req->fetch();

		// Comparaison du pass envoyé via le formulaire avec la base
		$isPasswordCorrect = password_verify($_POST['pass'], $resultat['pass']);

		if (!$resultat)
		{
		    $error = 'Mauvais identifiant ou mot de passe !<br>';
		}
		else
		{
		    if ($isPasswordCorrect) 
		    {
		    	if (isset($_POST['autoconnect'])) 
		    	{
		    		setcookie('pseudo', $pseudo, time() + 365*24*3600, null, null, false, true);
		    		setcookie('pass', $resultat['pass'], time() + 365*24*3600, null, null, false, true);
		    	}
		    	session_start();
		       	$_SESSION['pass'] = $resultat['pass'];
		       	$_SESSION['pseudo'] = $pseudo;
		       	$_SESSION['email'] = $resultat['email'];
		        echo 'Vous êtes connecté !';
		        header('Location: membres_espace.php');
		    }
		    else 
		    {
		        $error = 'Mauvais identifiant ou mot de passe !<br/>';
		    }
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="membres_css.css">
</head>
<body>
	<div id="page">
		<?php include '..\structure_de_page\en-tete.php'; ?>
		<h1>Connexion a l'espace membres</h1>
		<form action="membres_connexion.php" method="post">
			<p>
				<label for="pseudo">Pseudo: </label> 
				<input type="text" name="pseudo" id="pseudo" required/><br/>
				
				<label for="pass">Mot de passe: </label>
				<input type="password" name="pass" id="pass" required><br/>

				<label for="autoconnect">Connexion automatique: </label>
				<input type="checkbox" name="autoconnect" id="autoconnect" checked><br/>
				
				<input type="submit" value="connexion"/>
			</p>
		</form>
		<?php
		echo $error."<br>";
		?>
		<a href="membres_inscription.php">S'inscrire</a><br/>
		<a href="membres_oublier.php">Mot de passe oublier</a><br/>
		<?php include '..\structure_de_page\pied.php'; ?>
	</div>
</body>
</html>
