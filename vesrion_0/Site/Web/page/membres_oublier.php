<?php
session_start(); 
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projet web;charset=utf8', 'root', '');
}
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());
} 	
$msg = NULL;
if (isset($_POST['pseudo']) AND isset($_POST['email'])) 
{
	// On rend inoffensives les balises HTML 
	$_POST['pseudo'] = htmlspecialchars($_POST['pseudo']); 
	$_POST['email'] = htmlspecialchars($_POST['email']); 

	//  Récupération de l'utilisateur et de son pass hashé
	$req = $bdd->prepare('SELECT pseudo, email FROM membres WHERE pseudo = :pseudo AND email = :email');
	$req->execute(array('pseudo'=>$_POST['pseudo'], 'email'=>$_POST['email']));
	$resultat = $req->fetch();

	if (!$resultat)
	{
	    $msg = "Vous n'etes pas inscrit";
	}
	else
	{
		//https://waytolearnx.com/2019/07/comment-envoyer-un-mail-depuis-localhost-en-php.html
		$dest = $resultat['email'];
		$sujet = "Mot de passe oublier";
		$corp = 'Salut ceci est un email pour modifier votre mot de passe<br/><a href="http://172.16.32.25/premier_site/page/membres_espace.php">cliquez ici</a>';
		$headers = "Content-type: text/html; charset=UTF-8";
		if (mail($dest, $sujet, $corp, $headers)) 
		{
		   $msg = "Email envoyé avec succès à $dest ...";
		   $_SESSION['pseudo'] = $_POST['pseudo'];
		   $_SESSION['email'] = $_POST['email'];
		   setcookie('pseudo', $_POST['pseudo'], time() + 365*24*3600, null, null, false, true);
		} 
		else 
		{
		   $msg = "Échec de l'envoi de l'email...";
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
		<p>
			<h1>Mot de passe oublier</h1>
			<form action="membres_oublier.php" method="post">
				<p>
					<label for="pseudo">Pseudo: </label> 
					<input type="text" name="pseudo" id="pseudo" required/><br/>
					
					<label for="email">E-Mail: </label>
					<input type="email" name="email" id="email" required><br/>
					
					<input type="submit" value="Envoyer"/>
				</p>
			</form>
		</p>
		<?php
		echo $msg."<br>"; 
		?>
		<a href="membres_connexion.php">Se connecter</a>
		<?php include '..\structure_de_page\pied.php'; ?>
	</div>
</body>
</html>
