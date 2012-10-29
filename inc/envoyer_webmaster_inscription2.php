<?php

//email envoye lors de l'inscription
function inc_envoyer_webmaster_inscription2_dist($id_responsable_site,$nom_inscrit,$id_auteur) {
    include_spip('inc/mail');
	

	// On récupère les données nécessaires à envoyer le mail de validation
	// La fonction envoyer_mail se chargera de nettoyer cela plus tard
	$nom_site_spip = $GLOBALS['meta']["nom_site"];
	$adresse_site = $GLOBALS['meta']["adresse_site"];
	

    $var_user = sql_fetsel(
        "a.nom,$prenom $nom a.id_auteur, a.alea_actuel, a.login, a.email",
        "spip_auteurs AS a LEFT JOIN spip_auteurs_elargis AS b USING(id_auteur)",
        "a.id_auteur =$id_responsable_site"
    );
		$nom_final = $var_user['nom'];

	
    spip_log("envoie mail id: $id_auteur","inscription2");
    spip_log($var_user,'inscription2');

	$url_inscrit= generer_url_public("auteur","id_auteur=$id_auteur");
	$message = _T('inscription2:email_bonjour', array('nom'=> $nom_final))."\n\n"
.$nom_inscrit." vient de s'inscrire \n\n
Voir son profile: ".$url_inscrit;
		
	$sujet = "[".$nom_site_spip."] - Avis d\'inscription ! ";


    spip_log($message,'inscription2');

		$from = $GLOBALS['meta']["email_webmaster"]; 
		$expediteur= $nom_site_spip.'<'.$from.'>';		
// 		$entete .= "Reply-To: ".$from."\n"; 
// 		$entete .= "Return-Path: ".$from."\n"; 
// 		$entete .= "MIME-Version: 1.0\n";
// 		$entete .= "Content-Transfer-Encoding: 8bit\n";
// 		$entete .= "X-Mailer: PHP/" . phpversion();     
	if (envoyer_mail($var_user['email'],
			$sujet,
			$message,
			$expediteur))
		return;
	else
		return _T('inscription2:probleme_email');
}
?>