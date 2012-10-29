<?php

if (!defined("_ECRIRE_INC_VERSION")) return;


function formulaires_actualisations_divers_charger_dist($mode,$id_auteur='',$id_objet='',$url_retour='',$options=''){
	$valeurs = array('id_auteur'=>$id_auteur,'id_objet'=>$id_objet,'mode'=>$mode,'statut_livraison'=>'','email'=>'','bio'=>'','remise_vente_automatique'=>'','id_acheteur'=>'' );
	
	if($options=='super_asso')$valeurs['super_asso']='oui';
	
	if($mode=='remise_vente_automatique'){
		$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet' ");
				while($data = spip_fetch_array($sql)) {
				$valeurs['remise_vente_automatique']=$data['remise_vente_automatique'];	
				$valeurs['id_acheteur']=$data['id_acheteur'];					
				}	
	 	}

	return $valeurs;
}



function formulaires_actualisations_divers_traiter_dist($mode,$id_auteur='',$id_objet='',$url_retour='',$options=''){

$date_actuel=date('Y-m-d G:i:s');

	if($mode=='achats_effectues'){
		reset($_POST); 
		while (list($key, $val) = each($_POST)) { 
			if(preg_match('/id_bouton/', $key)){
				$id_objet=str_replace('id_bouton_','',$key); 
				$statut_livraison=_request('statut_livraison_'.$id_objet);
				spip_query ("UPDATE spip_encheres_objets SET statut_livraison = '$statut_livraison'  WHERE  id_objet='$id_objet'");				
				}
			}
			if($statut_livraison=='recu'){
				//Mail de confirmation au vendeur
				$envoyer_message_kidonateur = charger_fonction('envoyer_message_kidonateur','inc');
				$envoyer_message_kidonateur('','objet_recu_kidonateur',$id_objet);	
				}	
		spip_log("actions : kidonateur -achats_effectues: statut $statut_livraison ",'encheres_actions');	
		}

	if($mode=='objets_vendus'){
		reset($_POST); 
		while (list($key, $val) = each($_POST)) { 
			if(preg_match('/id_bouton/', $key)){
			$id_objet=str_replace('id_bouton_','',$key); 
			$statut_livraison=_request('statut_livraison_'.$id_objet);
			$statut_payement_livraison=_request('statut_payement_livraison_'.$id_objet);
			}
		}
		if ($statut_livraison){
			spip_query ("UPDATE spip_encheres_objets SET statut_livraison = '$statut_livraison' , date_livraison='$date_actuel'  WHERE  id_objet='$id_objet'");
		spip_log("actions : kidonateur - objet_vendus: statut_livraison: $statut_livraison ",'encheres_actions');	
			}
		if($statut_payement_livraison){
			spip_query ("UPDATE spip_encheres_objets SET statut_payement_livraison='$statut_payement_livraison', date_paiement_livraison='$date_actuel'  WHERE  id_objet='$id_objet'");
					
			//Mail de confirmation à l'acheteur
			$envoyer_message_acheteur = charger_fonction('envoyer_message_acheteur','inc');
			$envoyer_message_acheteur('','paiement_livraison_ok_acheteur',$id_objet);
					
			//Mail de confirmation au vendeur
			$envoyer_message_kidonateur = charger_fonction('envoyer_message_kidonateur','inc');
			$envoyer_message_kidonateur('','paiement_livraison_ok_vendeur',$id_objet);
			
			spip_log("actions : kidonateur - objet_vendus: statut_payement_livraison: $statut_livraison ",'encheres_actions');					
			}
	}

	if($mode=='objets_vendus_np_projets'){
		reset($_POST); 
		while (list($key, $val) = each($_POST)) { 
			if(preg_match('/id_bouton/', $key)){
			$id_objet=str_replace('id_bouton_','',$key); 
			$statut_payement_objet=_request('statut_payement_objet_'.$id_objet);
				}	
			}
		if($statut_payement_objet=='ok'){
			//change de statut pour cloturer la vente et enregistrement du mode de paiement
			
			$table='spip_encheres_objets';			
			
			sql_updateq($table,array('statut'=>'vente_termine','statut_payement_objet'=>$statut_payement_objet,'paiement_virement'=>1,'date_paiement_objet'=>$date_actuel),'id_objet='.$id_objet);
			
			//Actualiser la table kidonathon si active
			
			if(!lire_config('encheres/enlever_kidonathon')){
			
				$montant_mise=sql_getfetsel('montant_mise',$table,'id_objet='.$id_objet);
				
				$table='spip_encheres_kidonathons';
				
				if($id_kidonathon)$where='id_kidonathon='.$id_kidonathon;
				
				$kidonathon=sql_fetsel('id_kidonathon,montant',$table,$where);
				
				$montant=$montant_mise+$kidonathon['montant'];
				
				sql_updateq($table,array('montant'=>$montant),'id_kidonathon='.$kidonathon['id_kidonathon']);
						
			}

			// Actualise les données d'évaluation
			$objet= spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet'" );
			while($data4 = spip_fetch_array($objet)){
				$id_acheteur=$data4['id_acheteur'];	
				$id_vendeur=$data4['id_auteur'];			
				}
			
						
			$vendeur = spip_query( "SELECT * FROM spip_encheres_evaluations WHERE id_auteur='$id_vendeur'" );
			while($data2 = spip_fetch_array($vendeur)){
 				$objets_vendeur=$data2['objets_vendeur']+1;
  				$id_vendeur_teste=$data2['id_auteur'];
  				$score_vendeur=$data2['score']+2;  							 
				spip_query("UPDATE spip_encheres_evaluations SET objets_vendeur='$objets_vendeur', score='$score_vendeur' WHERE id_auteur='$id_vendeur'");
				}
				
			$acheteur = spip_query( "SELECT * FROM spip_encheres_evaluations WHERE id_auteur='$id_acheteur'" );
			while($data3 = spip_fetch_array($acheteur)) {
 				$score_acheteur=$data3['score']+1;					
 				$objets_acheteur=$data3['objets_acheteur']+1;
  				$id_acheteur_teste=$data3['id_auteur'];

				spip_query("UPDATE spip_encheres_evaluations SET objets_acheteur='$objets_acheteur', score='$score_acheteur' WHERE id_auteur='$id_acheteur'");			
				}	
				
			if(!$id_vendeur_teste){
				$arg_inser_eval_vendeur = array(
				'id_auteur' => $id_vendeur,
				'objets_vendeur' => '1',
				'score' => '2',								
					);
				$id_auteur = sql_insertq('spip_encheres_evaluations',$arg_inser_eval_vendeur);
				}	
			if(!$id_acheteur_teste){
				$arg_inser_eval_acheteur = array(
				'id_auteur' => $id_acheteur,
				'objets_acheteur' => '1',	
				'score' => '1',								
					);
				$id_auteur = sql_insertq('spip_encheres_evaluations',$arg_inser_eval_acheteur);
				}	
			
	    	// Invalider les caches
		include_spip('inc/invalideur');
	    	suivre_invalideur("id='id_objet/$id_objet'");
	    	suivre_invalideur("id='id_auteur/$id_auteur'");
	    	suivre_invalideur("id='id_kidonateur/$id_kidonateur'");	    	
					
			//Mail de confirmation au kidonateur
			$envoyer_message_kidonateur = charger_fonction('envoyer_message_kidonateur','inc');
			$envoyer_message_kidonateur('','paiement_ok_kidonateur',$id_objet);

			//Mail de confirmation à l'acheteur
			$envoyer_message_acheteur = charger_fonction('envoyer_message_acheteur','inc');
			$envoyer_message_acheteur('','paiement_ok_acheteur',$id_objet);

			//Mail d'info au webmaster
			$envoyer_message_webmestre = charger_fonction('envoyer_message_webmestre','inc');
			$envoyer_message_webmestre('paiement_ok',$id_objet);
			
			spip_log("actions : kidonateur - objets_vendus_np_projets - $statut_payement_objet=='ok'",'encheres_actions');	
			}	
		}

	if($mode=='evaluation_vendeur'){
			$evaluation_vendeur=_request('evaluation_vendeur');
			
			spip_query ("UPDATE spip_encheres_objets SET evaluation_vendeur='$evaluation_vendeur' WHERE  id_objet='$id_objet'");
			
			// Actualise les données d'évaluation
			$objet= spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet'" );
			while($data4 = spip_fetch_array($objet)){
				$id_vendeur=$data4['id_auteur'];			
				}
						
			$vendeur = spip_query( "SELECT * FROM spip_encheres_evaluations WHERE id_auteur='$id_vendeur'" );
			while($data2 = spip_fetch_array($vendeur)){
				$id_vendeur_teste = $data2['id_auteur'];
			 	$vendeur_positif=$data2['vendeur_positif'];
 				$vendeur_negatif=$data2['vendeur_negatif']; 				
 				$vendeur_neutre=$data2['vendeur_neutre'];
 				
 				if($evaluation_vendeur>0){
 					$vendeur_positif=$vendeur_positif+1;
 					$score=$data2['score']+1;}
 				elseif($evaluation_vendeur==0){
 					$vendeur_neutre=$vendeur_neutre+1;
 					$score=$data2['score'];
 					}
 				elseif($evaluation_vendeur<0){
 					$vendeur_negatif=$vendeur_negatif+1; 
 					$score=$data2['score']-1; 
 					}														 
				spip_query("UPDATE spip_encheres_evaluations SET vendeur_positif='$vendeur_positif', vendeur_neutre='$vendeur_neutre',vendeur_negatif='$vendeur_negatif', score='$score' WHERE id_auteur='$id_vendeur'");
				}
			if(!$id_vendeur_teste){
			 	if($evaluation_vendeur>0){
 					$vendeur_positif='1';
 					$score='1';}
 				elseif($evaluation_vendeur==0){
 					$vendeur_neutre='1';
 					$score=0;
 					}
 				elseif($evaluation_vendeur<0){
 					$vendeur_negatif='1'; 
 					$score='-1'; 
 					}
 					
				$arg_inser_eval_vendeur = array(
				'id_auteur' => $id_vendeur,
				'vendeur_positif' => $vendeur_positif,
				'vendeur_neutre' => $vendeur_neutre,
				'vendeur_negatif' => $vendeur_negatif,								
				'score' => $score,								
					);
				$id_auteur = sql_insertq('spip_encheres_evaluations',$arg_inser_eval_vendeur);
			}
			// Invalider les caches
	  		include_spip('inc/invalideur');
	   		suivre_invalideur("id='id_objet/$id_objet'");
	   		suivre_invalideur("id='id_auteur/$id_auteur'");
	   		
			spip_log("actions :evaluation_vendeur :$evaluation_vendeur ",'encheres_actions');		
		}
	if($mode=='evaluation_acheteur'){
			$evaluation_acheteur=_request('evaluation_acheteur');
			
			spip_query ("UPDATE spip_encheres_objets SET evaluation_acheteur='$evaluation_acheteur' WHERE  id_objet='$id_objet'");	
					
			// Actualise les données d'évaluation
			$objet= spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet'" );
			while($data4 = spip_fetch_array($objet)){
				$id_acheteur=$data4['id_acheteur'];			
				}
						
			$acheteur = spip_query( "SELECT * FROM spip_encheres_evaluations WHERE id_auteur='$id_acheteur'" );
			while($data2 = spip_fetch_array($acheteur)){
				$id_acheteur_teste = $data2['id_auteur'];
			 	$acheteur_positif=$data2['acheteur_positif'];
 				$acheteur_negatif=$data2['acheteur_negatif']; 				
 				$acheteur_neutre=$data2['acheteur_neutre'];
 				
 				if($evaluation_acheteur>0){
 					$acheteur_positif=$acheteur_positif+1;
 					$score=$data2['score']+1;}
 				elseif($evaluation_acheteur==0){
 					$acheteur_neutre=$acheteur_neutre+1;
 					$score=$data2['score'];
 					}
 				elseif($evaluation_acheteur<0){
 					$acheteur_negatif=$acheteur_negatif+1; 
 					$score=$data2['score']-1; 
 					}														 
				spip_query("UPDATE spip_encheres_evaluations SET acheteur_positif='$acheteur_positif', acheteur_neutre='$acheteur_neutre',acheteur_negatif='$acheteur_negatif', score='$score' WHERE id_auteur='$id_acheteur'");
				}
			if(!$id_acheteur_teste){
			 	if($evaluation_acheteur>0){
 					$acheteur_positif='1';
 					$score='1';}
 				elseif($evaluation_acheteur==0){
 					$acheteur_neutre='1';
 					$score=0;
 					}
 				elseif($evaluation_acheteur<0){
 					$acheteur_negatif='1'; 
 					$score='-1'; 
 					}
 					
				$arg_inser_eval_acheteur = array(
				'id_auteur' => $id_acheteur,
				'acheteur_positif' => $acheteur_positif,
				'acheteur_neutre' => $acheteur_neutre,
				'acheteur_negatif' => $acheteur_negatif,								
				'score' => $score,								
					);
				$id_auteur = sql_insertq('spip_encheres_evaluations',$arg_inser_eval_acheteur);
			}		
			// Invalider les caches
	  		include_spip('inc/invalideur');
	   		suivre_invalideur("id='id_objet/$id_objet'");
	   		suivre_invalideur("id='id_auteur/$id_auteur'");	   					
	   					

		}
		
	if($mode=='remise_vente_automatique'){
			$remise_vente_automatique=_request('remise_vente_automatique');
			spip_query ("UPDATE spip_encheres_objets SET remise_vente_automatique='$remise_vente_automatique' WHERE  id_objet='$id_objet'");
		}		
	if($mode!='remise_vente_automatique')	{	
 $url_retour=str_replace('&amp;','&',$url_retour);
 header ('location:'.$url_retour);
}
}
?>