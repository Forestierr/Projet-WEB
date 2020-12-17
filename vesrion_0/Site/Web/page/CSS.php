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
				<p></p>
				<form method="post">
					<label>Votre Pseudo: </label>
					<input type="text" name="pseudo" required><br/>
					<textarea name="message" rows="3" cols="80" required></textarea><br/>
					<input type="submit" value="Envoyer">
				</form>	
			</div>
		</section>
		<h2>Le Code</h2>
		<div id="code">
			<img src="../image/css3.PNG">
			<div id="css">
				<img src="../image/css.PNG">
				<img src="../image/css2.PNG">
			</div>
		</div>
	</div>	
	</body>
</html>