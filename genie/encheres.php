<?php

function genie_encheres_dist($time){

$date_actuel= time();

include_spip('inc/utils');

// Cherche les objet en vente 
	$sql = sql_select('*','spip_encheres_objets','statut="mise_en_vente_active" OR statut="publie"');
		while($data = sql_fetch($sql)) {
     		$id_encheres_objet = $data['id_encheres_objet'];
     		$statut = $data['statut'];
    		$remise_vente_automatique=$data['remise_vente_automatique'];		
     		$date_fin = $data['date_fin'];
     		$date_fin_jours = date('d-m-Y',strtotime($date_fin));
     		$date_fin_heures = date('G:i:s',strtotime($date_fin));

           	$split_jours = explode("-", $date_fin_jours);
           	$split_heures = explode(":", $date_fin_heures);
         
           	$date_fin = mktime($split_heures[0], $split_heures[1], $split_heures[2], $split_jours[1], $split_jours[0], $split_jours[2]) ;
           	
         		$date_difference = ($date_fin-$date_actuel)/3600;
        
        		// Cloture de la vente 
        		if ($date_difference <= 0 ){

        			// Détermine l'action suivant si l'enchère est resté sans mises (statut: mise_en_vente) ou avec mises (statut : mise_en_vente_active)	
        			$actualiser = charger_fonction('actions_enchere_gagne','inc');
        			$actualiser('cloture_cron_'.$statut,$id_encheres_objet);
        			}
        
        		// Selectionne celles qui se termine dans les 24 heures
        		/*elseif ($date_difference <='24'){
        			// Cherche l'encherisseur gagnant actuel afin d'éviter de  lui envoyer un mail d'avis
        			$sql2 = spip_query( "SELECT * FROM spip_encheres_mises WHERE id_objet='$id_objet' ORDER BY montant_mise DESC LIMIT 1");
        
        				while($data = sql_fetch($sql2)) {
        					$id_encherisseur_top=$data['id_encherisseur'];
        					}
        
        			// Pour les perdant ou ceux qui suivent l'objet et qui n'on pas déjà re&ccedil;u un mail d'avertissement
        					$sql3 = spip_query( "SELECT * FROM spip_encheres_encherisseurs WHERE id_objet='$id_objet' AND id_encherisseur != '$id_encherisseur_top' AND envoi_avis !='24'" );
        						while($data = sql_fetch($sql3)) {
        
        						$id_auteur = $data['id_encherisseur'];
        
        						// Envoi des mails et mention de l'envoi dans la base de donnée et dans le log
        
        						$sql4 = spip_query( "SELECT * FROM spip_auteurs WHERE id_auteur='$id_auteur'" );
        							while($data = sql_fetch($sql4)) {
        							$email = $data['email'];
        
        								spip_log("CRON : action envoi mail 24 heures avant fin d'enchère: $id_objet email: $email",'encheres_cron');
        								$envoyer_message_acheteur = charger_fonction('envoyer_message_acheteur','inc');
        								$envoyer_message_acheteur($email,'avis_24_heures',$id_objet);
        
        							spip_query("UPDATE spip_encheres_encherisseurs SET envoi_avis='24' WHERE id_encherisseur='$id_auteur' AND id_objet='$id_objet'");
        							spip_log("CRON : update bdd: $id_objet email: $email",'encheres_cron');
        							}
        						}
        			if($remise_vente_automatique=='on' AND $statut=='mise_en_vente'){
        				$envoyer_message_kidonateur = charger_fonction('envoyer_message_kidonateur','inc');
        				$envoyer_message_kidonateur('','avis_24_heures_remise_auto',$id_objet);	
        					
        				spip_query("UPDATE spip_encheres_objets SET remise_vente_automatique='avis_envoye' WHERE id_objet='$id_objet'");
        				}
        			};*/

		}
		
/*
	$livre = spip_query( "SELECT * FROM spip_encheres_objets WHERE statut='vente_termine' AND statut_livraison!='envoie' AND statut_livraison!='recu' AND statut_payement_livraison='ok' AND date_paiement_livraison != '0000-00-00 00:00:00' AND envoi_rappels!='rappel_1_livraison' ORDER BY date_vente" );
		while($v = sql_fetch($livre)) {
		$id_objet = $v['id_objet'];
		$id_acheteur = $v['id_acheteur'];		
		$date_paiement_livraison = $v['date_paiement_livraison'];
		$date_paiement_livraison_jours = date('d-m-Y',strtotime($date_paiement_livraison));
 		$date_paiement_livraison_heures = date('G:i:s',strtotime($date_paiement_livraison));
		
   		$split_jours = explode("-", $date_paiement_livraison_jours);
   		$split_heures = explode(":", $date_paiement_livraison_heures);

   		$date_paiement_livraison_explode = mktime($split_heures[0], $split_heures[1], $split_heures[2], $split_jours[1], $split_jours[0], $split_jours[2]) ;
 		$date_difference_paiement_livraison = ($date_actuel-$date_paiement_livraison_explode)/86400;	
 		
 			 
 		if ($date_difference_paiement_livraison >= 8){
 		
 			//Envoi d'un rappel au vendeur
 			
 			$envoyer_message_kidonateur = charger_fonction('envoyer_message_kidonateur','inc');
			$envoyer_message_kidonateur('','rappel_vendeur_livraison',$id_objet);

			
			//Mail d'info au webmaster
			
			$envoyer_message_webmestre = charger_fonction('envoyer_message_webmestre','inc');
			$envoyer_message_webmestre('rappel_vendeur',$id_objet);
			
			spip_query("UPDATE spip_encheres_objets SET envoi_rappels='rappel_1_livraison' WHERE id_objet='$id_objet'");
			
			spip_log("CRON : rappel vendeur 8 jours depuis paiement livraison: id_objet: $id_objet ",'encheres_cron');
 		
 			} 
 		}

	$recu = spip_query( "SELECT * FROM spip_encheres_objets WHERE statut='vente_termine' AND statut_livraison='envoie'" );
		while($v = sql_fetch($recu)) {
		$id_objet = $v['id_objet'];
		$id_acheteur = $v['id_acheteur'];	
		$date_livraison = $v['date_livraison'];
		
		$date_livraison_jours = date('d-m-Y',strtotime($date_livraison));
 		$date_livraison_heures = date('G:i:s',strtotime($datet_livraison));		
		
   		$split_jours = explode("-", $date_livraison_jours);
   		$split_heures = explode(":", $date_livraison_heures);
   		$date_livraison_explode = mktime($split_heures[0], $split_heures[1], $split_heures[2], $split_jours[1], $split_jours[0], $split_jours[2]) ;
 		$date_difference_livraison = ($date_actuel-$date_livraison_explode)/86400;

 		
 		$encherisseur = spip_query( "SELECT * FROM spip_encheres_encherisseurs WHERE id_encherisseur='$id_acheteur' AND id_objet='$id_objet' AND envoi_avis='rappel_1_recu'" );
 		while($v = sql_fetch($encherisseur)) {
 		$avis=$v['envoi_avis'];
 			}
 					 
		if ($date_difference_livraison >= 8 AND !$avis){
		 	$acheteur = spip_query( "SELECT * FROM spip_auteurs WHERE id_auteur='$id_acheteur'" );
 			
 			while($v = sql_fetch($acheteur)) {
 			$email_acheteur = $v['email'];
 			$envoyer_message_acheteur = charger_fonction('envoyer_message_acheteur','inc');
			$envoyer_message_acheteur($email_acheteur,'rappel_acheteur_recu',$id_objet);
			}
			
			spip_query("UPDATE spip_encheres_encherisseurs SET envoi_avis='rappel_1_recu' WHERE id_encherisseur='$id_acheteur' AND id_objet='$id_objet'");
			
			spip_log("CRON : rappel achteur 8 jours depuis livraison: id_objet: $id_objet ",'encheres_cron');
		 
		 }
	}*/
	return 1;
}

?>
