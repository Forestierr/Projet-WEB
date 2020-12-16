<!DOCTYPE html>
<html>
<head>
	<title>Tchat</title>
	<meta charset="utf-8">
</head>
<body>
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

		// Insertion du message à l'aide d'une requête préparée
		$req = $bdd->prepare('INSERT INTO tchat (pseudo, message, date) VALUES(?, ?, NOW())');
		$req->execute(array($_POST['pseudo'], $_POST['message']));

		// Redirection du visiteur vers la page du minichat
		header('Location: PHP.php');
	?>
</body>
</html>