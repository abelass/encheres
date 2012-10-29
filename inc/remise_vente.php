<?php

function inc_remise_vente_dist ($id_objet='',$valeurs='',$type=''){
		if($id_objet){$id_objet=$id_objet;}
		else{$id_objet = $valeurs['id_objet']; }
						
 			$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet' ");
				while($data = spip_fetch_array($sql)) {
				$id_article=$data['id_article'];				
				$id_objet_source=$data['id_objet_source'];
 				$prix_achat_inmediat=$data['prix_achat_inmediat'];
 				$prix_depart = $data['prix_depart'];
				$duree = $data['duree'];
				$id_rubrique = $data['id_rubrique'];
				$remise_vente_automatique = $data['remise_vente_automatique'];			
 				$mode_livraison=$data['mode_livraison'];
 				$livraison_etranger=$data['livraison_etranger']; 				
 				$prix_livraison=$data['prix_livraison'];
  				$prix_livraison_etranger=$data['prix_livraison_etranger'];				
				$nombre=$data['nombre'];
				$date_creation=$data['date_creation'];
				$date_debut=$data['date_debut'];
 				$statut=$data['statut'];
 				$type=$data['type'];
				$date_debut_programmee=$data['date_debut'];
				$courrier_velo=$data['courrier_velo'];
				$remise_vente_automatique=$data['remise_vente_automatique'];	
				 	$art = spip_query( "SELECT * FROM spip_articles WHERE id_article='$id_article' ");
						while($data = spip_fetch_array($art)) {	
							$id_rubrique=$data['id_rubrique'];							
						}		
 			}
 			
    		$date_debut = date('Y-m-d G:i:s');
		$date_fin = date('Y-m-d G:i:s', strtotime ($date_debut."$duree day"));
		 			
			if($valeurs){
				$valeurs['date_creation']=$date_creation;
				$valeurs['date_debut']=$date_debut;
				$valeurs['date_fin']=$date_fin;
				$valeurs['remise_en_vente']='1';		
				$id_rubrique= _request('id_rubrique');
				sql_updateq("spip_encheres_objets", $valeurs, "id_objet='$id_objet'");							
				}
			else{
				spip_query("UPDATE spip_encheres_objets SET prix_depart='$prix_depart',montant_mise='$prix_depart',duree='$duree',statut='mise_en_vente',date_debut='$date_debut',date_fin='$date_fin',date_vente='0000-00-00 00:00:00',remise_vente_automatique='$remise_vente_automatique',envoi_rappels ='',remise_en_vente ='1'  WHERE id_objet='$id_objet'");
				}
				
			spip_query("UPDATE spip_articles SET  id_rubrique='$id_rubrique'  WHERE id_article='$id_article'");
			
			// Invalider les caches
	   		include_spip('inc/invalideur');
	   		suivre_invalideur("id='id_objet/$id_objet'");
	   		
	   		//Mail d'information aux perdants de l'enchère
					$sql = spip_query( "SELECT * FROM spip_encheres_encherisseurs WHERE id_objet='$id_objet' AND gagne='0' AND suivre!='1'");
						while($data = spip_fetch_array($sql)) {
						$id_encherisseur=$data['id_encherisseur'];
						$sql2 = spip_query( "SELECT * FROM spip_auteurs WHERE id_auteur='$id_encherisseur'");
							while($data = spip_fetch_array($sql2)) {
							$email = $data['email'];
 							$envoyer_message_acheteur = charger_fonction('envoyer_message_acheteur','inc');
 							$envoyer_message_acheteur($email,'remise_en_vente_sans_payer',$id_objet);
								}
							}
					
			spip_query ("DELETE FROM spip_encheres_encherisseurs WHERE id_objet='$id_objet'");
			spip_query ("DELETE FROM spip_encheres_mises WHERE id_objet='$id_objet'");			
				
}

?>
