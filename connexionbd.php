
<?php
	//On inclut les fichiers utilisés
	require_once('classes/BDD.php');

	//On crée une nouvelle Base de données
	$BDD = new BDD("root","site_php","","localhost");
	//On s'y connecte
	$BDD->connexion();

	//Pour éviter les erreurs d'accent dans les mots
	$requete = $BDD->getPdo()->prepare("SET NAMES utf8");
	$requete->execute();

	//Ajout d'un prefixe et d'un suffixe pour augmenter la sécurité des mots de passe
	define("PREFIXE","15af14gh");
	define("SUFFIXE","654ighj5");
?>