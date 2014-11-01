<?php

if($_POST) {

	header('Access-Control-Allow-Origin: *');
	
	/* Récupération des valeurs des champs du formulaire */
    if (get_magic_quotes_gpc())
    {
      $nom	     	= stripslashes(trim($_POST['name']));
      $expediteur	= stripslashes(trim($_POST['email']));
      $message		= stripslashes(trim($_POST['message']));
	  $dtfrom 		= stripslashes(trim($_POST['dtfrom']));
	  $dtto 			= stripslashes(trim($_POST['dtto']));
    }
    else
    {
      $nom		    = trim($_POST['nom']);
      $expediteur	= trim($_POST['email']);
      $message		= trim($_POST['message']);
	  $dtfrom 		= trim($_POST['dtfrom']);
	  $dtto 		= trim($_POST['dtto']);
    }
	
	$sujet = $nom.' a laissé un message sur le site leverger.fr.ht';
	
	/* Expression régulière permettant de vérifier si le 
    * format d'une adresse e-mail est correct */
    $regex_mail = '/^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$/i';
	
	/* Expression régulière permettant de vérifier qu'aucun 
    * en-tête n'est inséré dans nos champs */
    $regex_head = '/[\n\r]/';
	
	if ( empty($nom) || empty($expediteur) || empty($sujet) || empty($message) ) {
	
		echo('Des champs importants ne sont pas renseignés'.$nom.$expediteur.$sujet.$message);	
	}
	elseif (!preg_match($regex_mail, $expediteur)) {
	 
		echo('L\'adresse '.$expediteur.' n\'est pas valide');
    }
    /* On vérifie qu'il n'y a aucun header dans les champs */
    elseif (preg_match($regex_head, $expediteur)  || preg_match($regex_head, $nom) || preg_match($regex_head, $sujet)) {
			
		echo('En-têtes interdites dans les champs du formulaire');
    }
	else {
	
		/* Destinataire (votre adresse e-mail) */
		$to = 'xavier.pocquerusse@gmail.com';
	 
		/* Construction du message */
		$msg  = 'Joëlle,'."\r\n\r\n";
		$msg .= 'Ce mail a été envoyé depuis le site leverger.fr.ht par '.$nom." (" .$expediteur.")\r\n\r\n";
		$msg .= 'Voici le message qui vous est adressé :'."\r\n";
		$msg .= '---------------------------------------'."\r\n";
		$msg .= 'Date d\'arrivée : '.$dtfrom."\r\n";
		$msg .= 'Date de départ : '.$dtto."\r\n";
		$msg .= $message."\r\n";
		$msg .= '---------------------------------------'."\r\n";
			
		/* Envoi de l'e-mail */
		if (mail ("$to", "$sujet", "$msg", "From: leverger@fr.ht")) {

			echo("SUCCESS");
			unset($_POST);		/* On détruit la variable $_POST */
		}
		else {   
			echo('Erreur d\'envoi de l\'e-mail');
		}
	}
}
else {
	echo('');
}
?>