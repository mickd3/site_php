<?php
	//On démarre la session
	session_start();

	//On inclut les fichiers utilisés
	require_once('classes/form.php');

	//On regarde si on est bien connecté en Administrateur
	if(!isset($_SESSION['admin']) || $_SESSION['admin'] == 0){
		//Si non, on retourne à la page d'accueil
		header('Location: index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Galerie-Card || Administrateur</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="bandeau">
		<?php
			//On regarde si on a un message d'erreur
			if(isset($_GET['message'])){
				echo $_GET['message'];
			}
		?>
			<a id="ajoutPhoto" href="administrateurAjout.php">Ajout photo</a>
			<a class="cataloguePhoto" href="administrateurSuppr.php">Catalogue photo</a>

		<?php	
			//Formulaire de déconnexion de l'utilisateur
			$form_deconnexion = new form("deconnexion","deconnexion.php","post","");
			$form_deconnexion->setsubmit("validerdeconnexion","Deconnexion");
			$form_deconnexion->getform();
		?>
	</div>
	<div id="contenu">
		<h1>Ajout de photo</h1>
		<?php
			//On ajoute le formulaire d'ajout de photo à la page
			$formAjoutPhoto = new form("ajoutPhoto","form_ajoutImage.php","post","multipart/form-data");
			//On restreint les tailles de photos à 1Go
			$formAjoutPhoto->setinput("hidden","tailleMaxImage","1000000",0);
			$formAjoutPhoto->setinput("file","lienImage","Télécharger une image",0);
			$formAjoutPhoto->setinput("text","nomImage","Nom de la photo",1);
			$formAjoutPhoto->setinput("text","lieuImage","Lieu de prise de l'image",1);
			$formAjoutPhoto->setinput("text","jourImage","JJ",1);
			$formAjoutPhoto->setinput("text","moisImage","MM",1);
			$formAjoutPhoto->setinput("text","anneeImage","AAAA",1);
			$formAjoutPhoto->setinput("text","evenementImage","Evenement",1);
			$formAjoutPhoto->setinput("text","mot_cleImage","Mot(s) clé",0);
			$formAjoutPhoto->setinput("text","prixImage","Prix €",1);
			$formAjoutPhoto->setsubmit("validerAjout","Ajouter");
			$formAjoutPhoto->getform();
		?>
	</div>
</body>
</html>