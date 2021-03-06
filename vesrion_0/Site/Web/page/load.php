<?php
	try
	{
		// On se connecte à MySQL
		$bdd = new PDO('mysql:host=localhost;dbname=projet web;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e)
	{
		// En cas d'erreur, on affiche un message et on arrête tout
		die('Erreur : '.$e->getMessage());
	}
	$demande = $bdd->query('SELECT pseudo, message, DATE_FORMAT(date, "%d/%m/%Y") AS date FROM tchat ORDER BY id DESC LIMIT 0,10');
	while ($donnees = $demande->fetch()) 
	{
		$pseudo = htmlspecialchars($donnees['pseudo']);
		$date = htmlspecialchars($donnees['date']);
		$message = htmlspecialchars($donnees['message']);
								
		$message = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $message);
		$message = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $message);
		$message = preg_replace('#\[m\](.+)\[/m\]#isU', '<mark>$1</mark>', $message);
		$message = preg_replace('#(.+)\[br/\]#isU', '$1<br/>', $message);
		$message = preg_replace('#\[color=(red|green|blue|yellow|purple|olive)\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $message);
		$message = preg_replace('#https?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $message);
								
		echo '<strong> '.$pseudo.'</strong> Le '.$date.'<br/>'.$message.'<br/>';
	}
?>