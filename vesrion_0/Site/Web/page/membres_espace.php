<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="membres_css.css">
<head>
	<title></title>
</head>
<body>
	<div id="page">
		<?php include '..\structure_de_page\en-tete.php'; ?>
		<section>
			<div id="membres">
				<div id="espace_membres">
					<h1>Espace membres</h1>
					<p>
						<form action="membres_modification_profil.php" method="post" enctype="multipart/form-data">
							<label>Avatar:</label><br/>
							<input type="file" name="avatar"><br/>

							<input type="submit" name="Modifier" value="Modifier">
						</form>
					</p>
					<p>
						<form action="membres_modification_profil.php" method="post" enctype="multipart/form-data">

							<label for="pseudo">Pseudo: </label><br/> 
							<input type="text" name="pseudo" id="pseudo" required/><br/>

							<label for="email">Adresse E-Mail: </label><br/>
							<input type="email" name="email" id="email" required><br/>

							<label for="pass">Mot de passe: </label><br/>
							<input type="password" name="pass" id="pass" required><br/>

							<label for="repass">Retapez votre mot de passe: </label><br/>
							 <input type="password" name="repass" id="repass" required><br/>

							<input type="submit" name="Modifier" value="Modifier">
						</form>
					</p>
				</div>
				<div id="profil">
					<h2>Profil</h2>
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
				  			
				  		if (isset($_SESSION['pseudo'])) 
				  		{
				  			$req = $bdd->prepare('SELECT avatar, email, DATE_FORMAT(date_inscription, "%d/%m/%Y") AS date FROM membres WHERE pseudo = :pseudo');
					  		$req->execute(array('pseudo'=>$_SESSION['pseudo']));
					  		$info = $req->fetch();
					  		$avatar = $info['avatar'];
					  		$email = $info['email'];
					  		$inscription = $info['date'];
				  			
				  			if ($avatar == NULL)
				  			{
				  				echo '<img src="../upload/portrait_mini.png" alt="avatar"/>';
				  			}
				  			else
				  			{
				  				echo '<img src="../upload/'.$avatar.'" alt="avatar"/>';
				  			}
				  		}
				  		// affiche les info du compte
				  		echo "<br/>Pseudo: ".$_SESSION['pseudo']."<br/>E-Mail: ".$email."<br/>Date d'inscription: ".$inscription;
				  		if (isset($_SESSION['msg'])) 
				  		{
				  			$msg = $_SESSION['msg'];
				  			echo "<br/><strong>".$msg."</strong><br/>";
				  			$_SESSION['msg'] = NULL;
				  		}
						?>
					</p>
					<a href="membres_deconnexion.php">Se déconnecter</a>
				</div>	
			</div>
			<div id="tchat">
				<h2>Tchat</h2>
				<p>
					<?php
						$demande = $bdd->query('SELECT pseudo, message, DATE_FORMAT(date, "%d/%m/%Y") AS date FROM membres_tchat ORDER BY id DESC LIMIT 0,10');
						while ($donnees = $demande->fetch()) 
						{
							$idpseudo = $donnees['pseudo'];
							$message = htmlspecialchars($donnees['message']);
							$date = $donnees['date']; 
							
							$req = $bdd->prepare('SELECT pseudo, avatar FROM membres WHERE id = ?');
							$req->execute(array($idpseudo));
							$donnees = $req->fetch();
							$pseudo = $donnees['pseudo'];
							$avatar = $donnees['avatar'];

							if ($avatar == NULL)
				  			{
				  				$avatar = "portrait_mini.png";
				  			}

				  			$message = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $message);
				  			$message = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $message);
				  			$message = preg_replace('#\[m\](.+)\[/m\]#isU', '<mark>$1</mark>', $message);
				  			$message = preg_replace('#(.+)\[br/\]#isU', '$1<br/>', $message);
				  			$message = preg_replace('#\[color=(red|green|blue|yellow|purple|olive)\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $message);
				  			$message = preg_replace('#https?://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $message);

							echo '<img src="../upload/'.$avatar.'"><strong> '.$pseudo.'</strong> Le '.$date.'<br/>'.$message.'<br/>';
						}
					?>
				</p>
				<form method="post" action="membres_modification_profil.php">
					<textarea name="message" rows="3" cols="80" required></textarea><br/>
					<input type="submit" value="Envoyer">
				</form>	
			</div>
		</section>
		<?php include'..\structure_de_page\pied.php'; ?>
	</div>	
</body>
</html>