<?php

if($_POST) {

	header('Access-Control-Allow-Origin: *');
	
	/* Récupération des valeurs des champs du formulaire */
    if (get_magic_quotes_gpc())
    {
      $nom	     	= stripslashes(trim($_POST['name']));
      $expediteur	= stripslashes(trim($_POST['email']));
      $message		= stripslashes(trim($_POST['message']));
    }
    else
    {
      $nom		    = trim($_POST['nom']);
      $expediteur	= trim($_POST['email']);
      $message		= trim($_POST['message']);
    }
	
	$sujet = 'Quelqu\'un à posté un message sur arche.contes.tumblr.com';
	
	/* Expression régulière permettant de vérifier si le 
    * format d'une adresse e-mail est correct */
    $regex_mail = '/^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$/i';
	
	/* Expression régulière permettant de vérifier qu'aucun 
    * en-tête n'est inséré dans nos champs */
    $regex_head = '/[\n\r]/';
	
	if ( empty($nom) || empty($expediteur) || empty($sujet) || empty($message) ) {
	
		echo('Des champs importants ne sont pas renseignés');	
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
        $msg  = 'Michael,'."\r\n\r\n";
        $msg .= 'Ce mail a été envoyé depuis arche.contes.tumblr.com par '.$nom." (" .$expediteur.")\r\n\r\n";
        $msg .= 'Voici le message qui vous est adressé :'."\r\n";
        $msg .= '---------------------------------------'."\r\n";
        $msg .= $message."\r\n";
        $msg .= '---------------------------------------'."\r\n";
 
		/* En-têtes de l'e-mail */
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $to)) {	/* On filtre les serveurs qui rencontrent des bogues. */
			$passage_ligne = "\r\n";
		} else {
			$passage_ligne = "\n";
		}
		
		/* Création de la boundary */
		$boundary = "-----=".md5(rand());

		/* Création du header de l'e-mail */
		$header = "From: \"$nom\"<arche.contes@tumblr.com>".$passage_ligne;
		$header.= "Reply-to: \"$nom\" <arche.contes@tumblr.com>".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		
		/* Envoi de l'e-mail */
        if (mail($to, $sujet, $msg, $header)) {
		
           echo("SUCCESS");
         
		   /* On détruit la variable $_POST */
           unset($_POST);
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