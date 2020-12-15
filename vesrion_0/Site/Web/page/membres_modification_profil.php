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
//lance les session
session_start();

//control si il ya un fichier et qu'il n'y a pas d'erreur
if (isset($_FILES['avatar']) AND $_FILES['avatar']['error'] == 0) 
{
	//control si la taille du fichier ne depasse pas 5 Mo 
	if ($_FILES['avatar']['size'] <= 5000000) 
	{
		//control le type de l'image
		$infofichier = pathinfo($_FILES['avatar']['name']);
		$extension_upload = $infofichier['extension'];
		$extension_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
		
		//change le nom de l'image
		$req = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
		$req->execute(array('pseudo' => $_SESSION['pseudo']));
		$name = $req->fetch();
		$name = $name['id'];
		$file = $name.'.'.$extension_upload;

		//engistre le nom de l'image  a la personne 
		$req = $bdd->prepare('UPDATE membres SET avatar = :avatar WHERE pseudo = :pseudo');
		$req->execute(array('avatar' => $file, 'pseudo' => $_SESSION['pseudo']));

		if (in_array($extension_upload, $extension_autorisees)) 
		{
			//engistre l'image sur le site
			move_uploaded_file($_FILES['avatar']['tmp_name'], '../upload/'.$file);
			//engistre le nom de l'image  a la personne 
			$req = $bdd->prepare('UPDATE membres SET avatar = :avatar WHERE pseudo = :pseudo');
			$req->execute(array('avatar' => $file, 'pseudo' => $_SESSION['pseudo']));
		}
	}	
}

if (isset($_FILES['avatar']) AND $_FILES['avatar']['error'] == 1) 
{
	$phpFileUploadErrors = $_FILES['avatar']['error'];

	$_SESSION['msg'] = "Erreur de l'image<br/>".$phpFileUploadErrors;

	//REPONSE DE LA VALEUR DU NOMBRE
	//0 => There is no error, the file uploaded with success
    //1 => The uploaded file exceeds the upload_max_filesize directive in php.ini
    //2 => The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form
    //3 => The uploaded file was only partially uploaded
    //4 => No file was uploaded
    //6 => Missing a temporary folder
    //7 => Failed to write file to disk.
    //8 => A PHP extension stopped the file upload.
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
				//regarde si le pseudo est deja pris en les mettants en miniscule
				$donnees = strtolower($donnees['pseudo']);
				$pseudo = strtolower($_POST['pseudo']);

				if ($donnees != $pseudo OR $_POST['pseudo'] == $_SESSION['pseudo']) 
				{	
					//regarde si le pseudo est deja pris en les mettants en miniscule
					$donnees = strtolower($donnees['email']);
					$email = strtolower($_POST['email']);

					if ($donnees == $email OR $_POST['email'] != $_SESSION['email']) 
					{	
						// message d'erreur et met une variable comme erreur
						$_SESSION['msg'] = 'L\'e-mail est deja pris';
						$verification = 1;
					}
				}
				else
				{
					// message d'erreur et met une variable comme erreur
					$_SESSION['msg'] = 'Le pseudo est deja pris';
					$verification = 1;
				}
			}
		}
		else
		{
			// message d'erreur et met une variable comme erreur
			$_SESSION['msg'] = 'L\'adresse ' . $_POST['email'] . ' n\'est pas valide, recommencez !';
			$verification = 1;
		}	
	}
	else
	{
		// message d'erreur et met une variable comme erreur
		$_SESSION['msg'] = "Les mots de passe ne sont pas identiques";
		$verification = 1;
	}

	//modifie les infos dans la basse de donnees si tout t'est bon
	if ($verification != 1) 
	{
		// Hachage du mot de passe
		$pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);

		$req = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
		$req->execute(array('pseudo' => $_SESSION['pseudo']));
		$id = $req->fetch();
		$id = $id['id'];

		// mettre a jour
		$req = $bdd->prepare('UPDATE membres SET pseudo = :nvpseudo, pass = :nvpass, email = :nvemail WHERE id = :id');
		$req->execute(array(
			'nvpseudo' => $_POST['pseudo'], 
			'nvpass' => $pass_hache,
			'nvemail' => $_POST['email'],
			'id' => $id));
		setcookie('pseudo', $_POST['pseudo'], time() + 365*24*3600, null, null, false, true);
		setcookie('pass', $pass_hache, time() + 365*24*3600, null, null, false, true);
		$_SESSION['pseudo'] = $_POST['pseudo'];
		$_SESSION['pass'] = $pass_hache;
	}				
}	

if (isset($_POST['message'])) 
{
	$req = $bdd->prepare('SELECT id FROM membres WHERE pseudo = :pseudo');
	$req->execute(array('pseudo' => $_SESSION['pseudo']));
	$id = $req->fetch();
	$id = $id['id'];

	$req = $bdd->prepare('INSERT INTO membres_tchat (pseudo, message, date) VALUES (?, ?, NOW())');
	$req->execute(array($id, $_POST['message']));
}

//redirection de la page
header('Location: membres_espace.php');
?>