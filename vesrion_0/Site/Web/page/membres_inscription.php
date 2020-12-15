<?php
session_start();
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
		<div>
				<h1>S'inscrire a l'espace membres</h1>
					<form action="membres_inscription.php" method="post">
				    	<p>
					        <label for="pseudo">Pseudo: </label> 
					        <input type="text" name="pseudo" id="pseudo" required/><br/>
					        <label for="email">Adresse E-Mail: </label>
					        <input type="email" name="email" id="email" required><br/>
					        <label for="pass">Mot de passe: </label>
					        <input type="password" name="pass" id="pass" required><br/>
					        <label for="repass">Retapez votre mot de passe: </label>
					        <input type="password" name="repass" id="repass" required><br/>
					        <input type="submit" value="s'inscrire"/>
						</p>
				    </form>
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

					if (isset($_POST['pseudo'])) 
					{
						//variable mis a 0
						$verification = 0;

						// On rend inoffensives les balises HTML 
						$_POST['pseudo'] = htmlspecialchars($_POST['pseudo']); 
						$_POST['pass'] = htmlspecialchars($_POST['pass']); 
						$_POST['repass'] = htmlspecialchars($_POST['repass']); 
						$_POST['email'] = htmlspecialchars($_POST['email']);

						//control le mot de passe
						if ($_POST['pass'] == $_POST['repass']) 
						{
							//control si l'addresse est valide
						    if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email']))
						    {
							    //controle si le pseudo est deja utiliser
								$req = $bdd->query('SELECT pseudo, email FROM membres');
						  		while ($donnees = $req->fetch()) 
								{
									//regarde si le pseudo et l'email sont deja pris en les mettants en miniscule
									$dPseudo = strtolower($donnees['pseudo']);
									$dEmail = strtolower($donnees['email']);
									$email = strtolower($_POST['email']);
									$pseudo = strtolower($_POST['pseudo']);

									if ($dPseudo != $pseudo) 
									{
										if ($dEmail == $email) 
										{
											// message d'erreur et met une variable comme erreur
											echo "L'e-mail est deja utiliser";
											$verification = 1;
										}
									}
									else
									{
										// message d'erreur et met une variable comme erreur
										echo "Le pseudo est deja pris";
										$verification = 1;
									}
								}
						    }
						    else
						    {
						    	// message d'erreur et met une variable comme erreur
						        echo 'L\'adresse ' . $_POST['email'] . ' n\'est pas valide, recommencez !';
						        $verification = 1;
							}	
						}
						else
						{
							// message d'erreur et met une variable coome erreur
							echo "Les mots de passe ne sont pas identiques";
							$verification = 1;
						}
						//insert les infos dans la basse de donnees si tout t'est bon
						if ($verification != 1) 
						{
							// Hachage du mot de passe
							$pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);

							// Insertion
							$req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email, date_inscription) VALUES(:pseudo, :pass, :email, CURDATE())');
							$req->execute(array(
								'pseudo' => $_POST['pseudo'], 
								'pass' => $pass_hache,
								'email' => $_POST['email']));

							setcookie('pseudo', $_POST['pseudo'], time() + 365*24*3600, null, null, false, true);
				    		setcookie('pass', $pass_hache, time() + 365*24*3600, null, null, false, true);

				    		$_SESSION['pseudo'] = $_POST['pseudo'];
				    		$_SESSION['email'] = $_POST['email'];
				    		$_SESSION['pass'] = $pass_hache;
							// Redirection du visiteur vers la page de connexion
							header('Location: membres_connexion.php');
						}				
					}	
				?>
				<br/>
				<a href="membres_connexion.php">Se connecter</a>
		</div>
		<?php include '..\structure_de_page\pied.php'; ?>
	</div>
</body>
</html>