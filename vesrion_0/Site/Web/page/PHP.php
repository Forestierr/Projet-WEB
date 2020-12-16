<!DOCTYPE html>
<html>
<head>
	<title>PHP & SQL</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="CSS.css">
</head>
<body>
	<div id="page">
		<?php include '..\structure_de_page\en-tete.php'; ?>
		<section>
			<div id="tchat">
				<h2>Tchat</h2>
				<p>
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
							$pseudo = $donnees['pseudo'];
							$date = $donnees['date'];
							$message = $donnees['message'];
							
				  			$message = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $message);
				  			$message = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $message);
				  			$message = preg_replace('#\[m\](.+)\[/m\]#isU', '<mark>$1</mark>', $message);
				  			$message = preg_replace('#(.+)\[br/\]#isU', '$1<br/>', $message);
				  			$message = preg_replace('#\[color=(red|green|blue|yellow|purple|olive)\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $message);
				  			$message = preg_replace('#https?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $message);
							
							echo '<strong> '.$pseudo.'</strong> Le '.$date.'<br/>'.$message.'<br/>';
						}
					?>
				</p>
				<form method="post" action="Tchat.php">
					<label>Votre Pseudo: </label>
					<input type="text" name="pseudo" required><br/>
					<textarea name="message" rows="3" cols="80" required></textarea><br/>
					<input type="submit" value="Envoyer">
				</form>	
			</div>
		</section>
	</div>	
</body>
</html>