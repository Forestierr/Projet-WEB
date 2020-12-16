<!DOCTYPE html>
<html>
<head>
	<title>Css</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="CSS.css">
</head>
	<body>
		<div id="page">
			<?php include '..\structure_de_page\en-tete.php'; ?>
		<section>
			<div id="tchat">
				<h2>Tchat</h2>
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