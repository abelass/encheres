<?php


function inc_envoyer_message_webmaster_dist($type,$option1='',$option2='') {
    include_spip('inc/mail');
	
	// On récupère les données nécessaires à envoyer le mail de validation
	// La fonction envoyer_mail se chargera de nettoyer cela plus tard
	$nom_site_spip = $GLOBALS['meta']["nom_site"];
	$email = $GLOBALS['meta']["email_webmaster"]; 

	$sql = spip_query( "SELECT * FROM spip_auteurs WHERE id_auteur='$option2'");
		while($data = spip_fetch_array($sql)) {
		$nom =$data['nom'];
		}
		


	$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$option1'");
		while($data = spip_fetch_array($sql)) {
		$id_article =$data['id_article'];
		$envoi_rappels =$data['envoi_rappels'];
		$id_acheteur =$data['id_acheteur'];
		
		$sql3 = spip_query( "SELECT * FROM spip_auteurs WHERE id_auteur='$id_acheteur'");
		while($data = spip_fetch_array($sql3)) {
		$nom_gagnant =$data['nom'];
		}
		
		$sql2 = spip_query( "SELECT * FROM spip_articles WHERE id_article='$id_article'");
			while($date = spip_fetch_array($sql2)) {
			$texte =$date['texte'];
			$titre =$date['titre'];
			}
		}

			//email envoye lors de l'inscription

			if ($type=='inscription2'){
			$url_objet= generer_url_public("auteur","id_auteur=$option2");
			$url_objet= str_replace('&amp;','&',$url_objet); 
			$message = "Bonjour, \n\n"
.			$nom." vient de s'inscrire sur le site \n\n Voir son profil: ".$url_objet."\n\n L'équipe de Kidonaki";
			$sujet = '['.$nom_site_spip.'] - Inscription sur le site! ';
				}

			//email envoye lors de la mise en vente d'un objet

			elseif ($type=='mettre_en_vente'){
			$url_objet= generer_url_public("article","id_article=$id_article&id_objet=$option1");
			$url_objet= str_replace('&amp;','&',$url_objet); 
			$message = "Bonjour, \n\n"
.			$nom." vient de mettre en vente un objet \n\n".$titre." : ".$texte."\n\n Voir l'objet: ".$url_objet."\n\n L'équipe de Kidonaki";
			$sujet = '['.$nom_site_spip.'] - Mise en vente d\'objet ! ';
				}
				
				
				
			//email envoye lors d'une mise effectué
			elseif ($type =='mise'){
			$url_objet= generer_url_public("article","id_article=$id_article&id_objet=$option1");
			$url_objet= str_replace('&amp;','&',$url_objet); 
			$var_url = '&id_objet='.$option1;
			$message = "Bonjour, \n\n".$nom." vient d'enchérir sur l'objet:".$titre." : ".$texte.".\n\n Voir l'état actuel de l'objet en question: ".$url_objet.$var_url."\n\n L'équipe de Kidonaki";
			$sujet = '['.$nom_site_spip.'] - Enchère éfectué ! ';
				}
			//email envoye lors de la fin d'une enchère
			elseif ($type=='enchere_gagnee'){
			$url_objet= generer_url_public("article","id_article=$id_article&id_objet=$option1");
			$url_objet= str_replace('&amp;','&',$url_objet); 
			$var_url = '&id_objet='.$option1;
			$message = "Bonjour, \n\n".$nom_gagnant." vient de gagner une enchère. Voir l'objet en question: ".$url_objet."\n\n L'équipe de Kidonaki";
			$sujet = "[".$nom_site_spip."]". $titre. "(".$option1.") - Enchère gagnée ! ";
				}


			//email envoye a partir du deuxième rappel
			elseif ($type=='rappel_acheteur'){
			$url_objet= generer_url_public("article","id_article=$id_article");
			$url_objet= str_replace('&amp;','&',$url_objet); 
			$var_url = '&id_objet='.$option1;
			$message = "Bonjour, \n\n ".$envoi_rappels." jours après sa vente, le paiement pour l'objet :".$titre." (".$option1.") n'as pas encore été enregistré et des rappels ont été envoyés".$url_objet."\n\n L'équipe de Kidonaki";
			$sujet = "[".$nom_site_spip."] - Envoi des rappels après ".$envoi_rappels." jours! ";
				}

			//email quand le paiement de l'objet est enregistré
			elseif ($type=='paiement_ok'){
			$url_objet= generer_url_public("article","id_article=$id_article&id_objet=$option1");
			$url_objet= str_replace('&amp;','&',$url_objet); 
			$var_url = '&id_objet='.$option1;
			$message = "Bonjour, \n\n le paiment pour l'objet".$titre." (".$option1.") a été enregistré,\n\n L'équipe de Kidonaki";
			$sujet = "[".$nom_site_spip."] - Paiement objet effectué!";
				}
				
			//email quand quand l'objet n'est pas livré 5 jours après paiement
			elseif ($type=='rappel_vendeur'){
			$url_objet= generer_url_public("article","id_article=$id_article&id_objet=$option1");
			$url_objet= str_replace('&amp;','&',$url_objet); 
			$var_url = '&id_objet='.$option1;
			$message = "Bonjour, \n\n 5 jours après le paiment pour la livraison de l'objet".$titre." (".$option1.") celui ci n'a toujours pas été livré. Un rappel a été envoyé au vendeur,\n\n L'équipe de Kidonaki";
			$sujet = "[".$nom_site_spip."] - Rappel livraison objet envoyé!";
				};	

	if($message){
		if (envoyer_mail($email,
			$sujet,
			$message))
			return spip_log("Email webmaster $email\n$sujet\n$message\n",'encheres_emails');
		else
			return spip_log("Échec envoi email webmaster $email\n$sujet\n$message\n",'encheres_emails');
	}
}
?>