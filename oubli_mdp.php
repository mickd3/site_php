<?php
	//On démarre la session
	session_start();

	//On inclut les fichiers utilisés
	require_once("connexionbd.php");
	require_once("classes/form.php");
	require_once("fonctions_oublimdp.php");

	//On crée la variable de session 'form'
	$_SESSION['form'] = $_POST;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Galerie-Card || Mot de passe oublié</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="bandeau">
		<?php
			//On regarde si on a un message d'erreur
			if(isset($_GET['message'])){
				echo $_GET['message'];
			}

			//On ajoute un lien sur la page d'accueil
			echo "<a id='accueil' href='index.php'>Accueil</a>";
				
		?>
	</div>
	<div class="contenu">
		<h1> Mot de passe oublié </h1>
		<p>Entrez votre login, nous vous enverrons un nouveau mot de passe à votre adresse mail.</p>

		<?php
			//On regarde si la personne a posté ou pas le formulaire
			//Si oui
			if(!empty($_POST)){
				//On sécurise le login posté
				$_login = htmlspecialchars($_POST['login']);

				//On effectue la requête SQL pour vérifier si l'utilisateur est inscrit 
				$resultat = $BDD->select("*","utilisateur","login = '" . $_login . "'");
				$resultat = $resultat->fetch();

				//Si c'est vide cela veut dire que l'utilisateur n'existe pas
				if(!empty($resultat)){

					//On crée un nouveau mot de passe aléatoire
					$pass=random_string(10);

					//l'envoi de mail n'ayant pas été possible en travaillant en local, on affiche le mot de passe pour notre version test
					//ceci n'est absolument pas sécurisé car n'importe qui peut obtenir le mdp pour un login donné
					//ceci sera réctifié lorsque l'envoi de mail sera possible
					echo $pass;

					//envoie du mot de passe par mail

/*

					$mail = $resultat[0]; // Déclaration de l'adresse de destination.

					if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn|gmail).[a-z]{2,4}$#", $mail)){ // On filtre les serveurs qui rencontrent des bogues.

    					$passage_ligne = "\r\n";

					}
					else{
						$passage_ligne = "\n";

					}	

					//=====Déclaration des messages au format texte et au format HTML.

						$message_txt = "Bonjour, voici ci-dessous votre nouveau mot de passe.\n Nous vous conseillons vivement de le changer dès votre prochaine connexion. \n".$pass;

						//$message_html = "<html><head></head><body><b>Bonjour</b>, voici ci-dessous votre nouveau mot de passe. <i>script PHP</i>.</body></html>";

					//==========


 					//=====Création de la boundary

						$boundary = "-----=".md5(rand());

					//==========


 					//=====Définition du sujet.

						$sujet = "Nouveau mot de passe";

					//=========


					//=====Création du header de l'e-mail.

						$header = "From: \"WeaponsB".$mail.$passage_ligne;

						$header.= "Reply-to: \"WeaponsB".$mail.$passage_ligne;

						$header.= "MIME-Version: 1.0".$passage_ligne;

						$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

					//==========


					//=====Création du message.

						$message = $passage_ligne."--".$boundary.$passage_ligne;


					//=====Ajout du message au format texte.

						$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;

						$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;

						$message.= $passage_ligne.$message_txt.$passage_ligne;

					//==========

						$message.= $passage_ligne."--".$boundary.$passage_ligne;


					//=====Ajout du message au format HTML

						$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;

						$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;

						//$message.= $passage_ligne.$message_html.$passage_ligne;

					//==========

						$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

						$message.= $passage_ligne."--".$boundary."--".$passage_ligne;

					//==========

 
					//=====Envoi de l'e-mail.

						mail($mail,$sujet,$message,$header);

					//==========

*/

					//On hash le mot de passe pour le mettre dans la base de données
					$newPass=$BDD->hash_password($pass);
					//On modifie le mot de passe de la base de données avec le nouveau mot de passe
					$BDD->modifierMdpUtilisateur($newPass,$_login);
					echo "Un mail a été envoyer à l'adresse correspondant au login : ".$_login;
					echo '<br>';
					echo "Cliquez <a href='index.php'> ici </a> pour retourner à la page d'accueil \n";


				}
				else{
					echo "Ce login n'existe pas, veuillez entré un login existant <br> ";
				}

			}

			//Formulaire à complété pour demander un nouveau mot de passe
			$form_oubli_mdp=new form("oubli_mdp","oubli_mdp.php","post","");
			$form_oubli_mdp->setinput("text","login","Login",1);
			$form_oubli_mdp->setsubmit("valider_oubli_mdp","valider");
			$form_oubli_mdp->setinput("reset","resset_oubli_mdp","",0);
			$form_oubli_mdp->getform();

		?>
	</div>
</body>
</html>