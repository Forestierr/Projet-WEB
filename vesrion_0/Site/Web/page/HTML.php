<!DOCTYPE html>
<html>
<head>
	<title>HTML</title>
	<meta charset="utf-8">
</head>
	<body>
		<div id="page">
			<div id="titre_principal">
				<div id="logo">
					<img src="../image/Logo_ELO_BA.png" alt="logo BA"/>
					<h1>Le Web</h1>
				</div>
				<h2>Robin & Maxime</h2>
			</div>
			<nav>
				<ul>
					<li><a href="../page/HTML.php#HTML">HTML5</a></li>
					<li><a href="../page/CSS.php#CSS">CSS3</a></li>
					<li><a href="../page/PHP.php#PHP">PHP & SQL</a></li>
				</ul>
			</nav>
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
		<h2>Le Code</h2>
		<img src="../image/html.PNG">
	</div>	
	</body>
</html>