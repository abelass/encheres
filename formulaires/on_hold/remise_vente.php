<?php

function inc_remise_vente_dist ($id_objet='',$valeurs='',$type=''){
		if($id_objet){$id_objet=$id_objet;}
		else{$id_objet = $valeurs['id_objet']; }
		
		//les donn&eacute;es de l'objet
	
		$objet = sql_fetsel('*','spip_encheres_objets',array('id_objet='.sql_quote($id_objet)));
						

		$id_article=$objet['id_article'];				
		$id_objet_source=$objet['id_objet_source'];
		$prix_achat_inmediat=$objet['prix_achat_inmediat'];
		$prix_depart = $objet['prix_depart'];
		$duree = $objet['duree'];
		$id_rubrique = $objet['id_rubrique'];
		$remise_vente_automatique = $objet['remise_vente_automatique'];			
		$mode_livraison=$objet['mode_livraison'];
		$prix_livraison=$objet['prix_livraison'];
		$nombre=$objet['nombre'];
		$date_creation=$objet['date_creation'];
		$duree=$objet['duree'];
		$date_debut=$objet['date_debut'];
		$statut=$objet['statut'];
		$type=$objet['type'];
		$date_debut_programmee=$objet['date_debut'];
		$courrier_velo=$objet['courrier_velo'];
				
				$remise_vente_automatique=$objet['remise_vente_automatique'];	
				
				$artobjet=sql_fetsel('*','spip_articles',array('id_article='.sql_quote($id_article)));

				$id_rubrique=$artobjet['id_rubrique'];							
	
 			
			if($valeurs){
				$prix_depart = $valeurs['prix_depart'];
				$duree = $valeurs['duree'];
				$id_rubrique = $valeurs['id_rubrique'];
				$remise_vente_automatique = $valeurs['remise_vente_automatique'];	
				}
			
    	$date_debut = date('Y-m-d G:i:s');
		$date_fin = date('Y-m-d G:i:s', strtotime ($date_debut."$duree day"));

			spip_query("UPDATE spip_encheres_objets SET prix_depart='$prix_depart',montant_mise='$prix_depart',duree='$duree',statut='mise_en_vente',date_debut='$date_debut',date_fin='$date_fin',date_vente='0000-00-00 00:00:00',remise_vente_automatique='$remise_vente_automatique',envoi_rappels =''  WHERE id_objet='$id_objet'");

			spip_query("UPDATE spip_articles SET  id_rubrique='$id_rubrique'  WHERE id_article='$id_article'");
			
			// Invalider les caches
	   		include_spip('inc/invalideur');
	   		suivre_invalideur("id='id_objet/$id_objet'");
			
			
					
			$projet=sql_fetsel('titre,id_auteur','spip_rubriques',array('id_rubrique='.sql_quote($artobjet['id_rubrique'])));				
							
			// Les infos de l'association
			$asso=sql_fetsel('nom','spip_auteurs',array('id_auteur='.sql_quote($projet['id_auteur'])))	;
														
		
	
			$contexte=array(
						'objet'=>$objet,
						'projet'=>$projet,
						'asso'=>$asso,
						'artobjet'=>$artobjet,					
						'kidonateur'=>'rien',																				
						);
	   		
	   		//Mail d'information aux perdants de l'enchère
					$sql = spip_query( "SELECT * FROM spip_encheres_encherisseurs WHERE id_objet='$id_objet' AND gagne='0' AND suivre!='1'");
						while($data = spip_fetch_array($sql)) {
						$id_encherisseur=$data['id_encherisseur'];
						$sql2 = spip_query( "SELECT * FROM spip_auteurs WHERE id_auteur='$id_encherisseur'");
							while($data = spip_fetch_array($sql2)) {
							$email = $data['email'];

							
							$envoyer_message_acheteur = charger_fonction('envoyer_message_acheteur','inc');
							$envoyer_message_acheteur($email,'remise_en_vente_sans_payer',$id_objet,$contexte);
								}
							}
					
		
			//Mail d'info au webmaster
 			$envoyer_inscription_webmaster = charger_fonction('envoyer_message_webmaster','inc');
 			$envoyer_inscription_webmaster('remise_en_vente',$id_objet,$id_auteur);
 			
 			if($type=='auto'){
 			$envoyer_message_visiteur = charger_fonction('envoyer_message_visiteur','inc');
			$envoyer_message_visiteur('','remise_automatique',$id_objet);
 			}
}

?>
