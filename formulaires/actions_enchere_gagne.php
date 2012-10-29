<?php
/* Fonction qui gères les actions après une vente gagné*/

function inc_actions_enchere_gagne_dist($type,$id_objet,$id_encherisseur=''){
 $date = date('Y-m-d G:i:s');
 $statut = 'vendu';
 $gagne='1';
 $id_objet_actuel=$id_objet;

		$sql = spip_query( "SELECT * FROM spip_auteurs WHERE id_auteur='$id_encherisseur'");
			while($data = spip_fetch_array($sql)) {
				$email = $data['email'];
				}

		$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet' ");
			while($data = spip_fetch_array($sql)) {
				$id_article = $data['id_article'];
				$remise_vente_automatique= $data['remise_vente_automatique'];
				}
	
		//Cherche une catégorie de l'objet actuel pour créer le lien recherche pour le mail aux encherisseurs perdants

		if ($type!='cloture_cron_mise_en_vente' AND $type!='cloture_mise_inmediat'){
				$mots_art = spip_query( "SELECT * FROM spip_mots_articles WHERE id_article='$id_article'");
 				while($data = spip_fetch_array($mots_art)) {
 					$id_mot = $data['id_mot'];
 					$mots = spip_query( "SELECT * FROM spip_mots WHERE id_mot='$id_mot' LIMIT 1");
						while($data = spip_fetch_array($mots)) {
 						$id_groupe = $data['id_groupe'];
 						}
 					$mots_groupes = spip_query( "SELECT * FROM spip_groupes_mots WHERE id_groupe='$id_groupe'");
						while($data = spip_fetch_array($mots_groupes)) {
 						$id_parent = $data['id_parent'];
						$var_url_categories = '&id_groupe1='.$id_groupe.'&recherche_etendue=oui#tableauobjets';

 						$sql1 = spip_query( "SELECT * FROM spip_groupes_mots WHERE id_groupe='$id_parent'");
							while($data = spip_fetch_array($sql1)) {
 							$id_parent = $data['id_parent'];
							$var_url_categories = '&id_groupe1='.$id_groupe.'&recherche_etendue=oui#tableauobjets';

 							$sql2 = spip_query( "SELECT * FROM spip_groupes_mots WHERE id_groupe='$id_parent'");
								while($data = spip_fetch_array($sql2)) {
 								$id_parent = $data['id_parent'];
								$var_url_categories = '&id_groupe1='.$id_groupe.'&recherche_etendue=oui#tableauobjets';
 								}
 							}
						}
 					}	
				}
				
		if ($type!='cloture_cron_mise_en_vente'){
			spip_query("UPDATE spip_encheres_objets SET statut='$statut',date_vente='$date', id_acheteur = '$id_encherisseur'   WHERE id_objet='$id_objet'");

			spip_query("UPDATE spip_encheres_encherisseurs SET gagne='$gagne'  WHERE id_objet='$id_objet' AND id_encherisseur='$id_encherisseur'");
			}

		elseif($remise_vente_automatique){
 			$remettre_en_vente = charger_fonction('remise_vente','inc');
 			$remettre_en_vente($id_objet,'','auto');
			}
		else{
			$statut='vendu';
			spip_query("UPDATE spip_encheres_objets SET statut='$statut'  WHERE id_objet='$id_objet'");
			}			

		$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE (statut='mise_en_vente' OR statut='mise_en_vente_active') AND id_article='$id_article'  ORDER BY id_objet DESC LIMIT 3");
		$compteur = 0;
			while($data = spip_fetch_array($sql)) {
				$compteur = $compteur+1;
					}

				$sql2 = spip_query( "SELECT * FROM spip_encheres_objets WHERE statut='stand_by'  AND id_article='$id_article'  ORDER BY id_objet DESC LIMIT 1");
					while($data = spip_fetch_array($sql2)) {
					$duree = $data['duree'];
					$statut = 'mise_en_vente';
					}
				$date_fin = date('Y-m-d G:i:s', strtotime ($date."$duree day"));
				$nombre = 3-$compteur;

				spip_query ("UPDATE spip_encheres_objets SET statut = '$statut', date_debut = '$date', date_fin = '$date_fin'  WHERE statut='stand_by' AND id_article='$id_article' ORDER BY id_objet LIMIT $nombre");
				
				if($nombre>0){
				$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE (statut='mise_en_vente') AND id_article='$id_article'  ORDER BY id_objet DESC LIMIT $nombre");
					while($data = spip_fetch_array($sql)) {
					$id_objet = $data['id_objet'];
					$statut = 'mise_en_vente_multi';
					
					//Mail d'info au webmaster
 					$envoyer_inscription_webmaster = charger_fonction('envoyer_message_webmaster','inc');
 					$envoyer_inscription_webmaster('mise_en_vente_multi',$id_objet);
					}
				}

				$id_objet = $id_objet_actuel;
				
				//Enregistre le log
				if ($type == 'cloture_mise_inmediat'){spip_log("Vente inmediate : action cloture de l'enchère: $id_objet",'encheres');};
				if ($type == 'cloture_cron_mise_en_vente_active'){spip_log("CRON : action cloture de l'enchère active: $id_objet",'encheres_cron');};
				if ($type == 'cloture_cron_mise_en_vente'){spip_log("CRON : action cloture de l'enchère sans mises: $id_objet",'encheres_cron');};

				//Envoi des différents mail
				//Cloture avec mises
				if ($type!='cloture_cron_mise_en_vente'){
				
					//Mail de confirmation au gagnant de l'enchère
					$envoyer_message_visiteur = charger_fonction('envoyer_message_visiteur','inc');
 					$envoyer_message_visiteur($email,'enchere_gagnee',$id_objet);

					//Mail de confirmation aux perdant de l'enchère
					$sql = spip_query( "SELECT * FROM spip_encheres_encherisseurs WHERE id_objet='$id_objet' AND gagne='0' AND suivre!='1'");
						while($data = spip_fetch_array($sql)) {
						$id_encherisseur=$data['id_encherisseur'];
						$sql2 = spip_query( "SELECT * FROM spip_auteurs WHERE id_auteur='$id_encherisseur'");
							while($data = spip_fetch_array($sql2)) {
							$email = $data['email'];
 							$envoyer_message_visiteur = charger_fonction('envoyer_message_visiteur','inc');
 							$envoyer_message_visiteur($email,'enchere_perdu',$id_objet,$var_url_categories);
								}
							}
					
					//Mail de confirmation au kidonateur
 					$envoyer_message_visiteur = charger_fonction('envoyer_message_visiteur','inc');
 					$envoyer_message_visiteur('','enchere_gagnee_kidonateur',$id_objet);

					//Mail de confirmation à l'association
 					$envoyer_message_visiteur = charger_fonction('envoyer_message_visiteur','inc');
 					$envoyer_message_visiteur('','enchere_gagnee_asso',$id_objet);

					//Mail d'info au webmaster
 					$envoyer_inscription_webmaster = charger_fonction('envoyer_message_webmaster','inc');
 					$envoyer_inscription_webmaster('enchere_gagnee',$id_objet,$id_encherisseur);
					}

				//Cloture sans mises

				else {
					//Mail de confirmation au kidonateur

					$envoyer_message_visiteur = charger_fonction('envoyer_message_visiteur','inc');
					$envoyer_message_visiteur('','enchere_cloture_sansmise_kidonateur',$id_objet);

					//Mail d'info au webmaster
 					$envoyer_inscription_webmaster = charger_fonction('envoyer_message_webmaster','inc');
 					$envoyer_inscription_webmaster('enchere_cloture_sansmise',$id_objet,$id_encherisseur);

						}
						
		// Invalider les caches
	   include_spip('inc/invalideur');
	   suivre_invalideur("id='id_objet/$id_objet'");
								
}
?>