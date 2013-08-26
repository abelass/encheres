<?php
/* Fonction qui gères les actions après une vente gagné*/

function inc_actions_enchere_gagne_dist($type,$id_objet,$id_encherisseur='',$contexte=''){
 $date = date('Y-m-d G:i:s');
 $statut = 'vendu';
 $gagne='1';
 $id_objet_actuel=$id_objet;
 
		include_spip('inc/encheresmail_fonctions');	
		
		// Les infos acheteur
		$acheteur= requete_auteurs_elargis(array('id_auteur='.sql_quote($id_encherisseur)));
		$email = $acheteur['email'];


		// Les infos de l'objet
		$objet=sql_fetsel('*','spip_encheres_objets',array('id_objet='.sql_quote($id_objet)));
		$id_article = $objet['id_article'];
		$remise_vente_automatique= $objet['remise_vente_automatique'];
		$date_stop_vente = $objet['date_stop_vente'];
		$statut_2 = $objet['statut'];	
		
		//les infos kidonateur
		$kidonateur = requete_auteurs_elargis(array('id_auteur='.sql_quote($objet['id_auteur'])),'compte_bancaire,bic');		

					
		// les infos projets	
						
		$artobjet=sql_fetsel('*','spip_articles',array('id_article='.sql_quote($id_article)));
					
		$projet=sql_fetsel('*','spip_rubriques',array('id_rubrique='.sql_quote($artobjet['id_rubrique'])));				
							
		// Les infos de l'association
		
		$asso = requete_auteurs_elargis(array('id_auteur='.sql_quote($projet['id_auteur'])));
		$asso['nom_asso']=$asso['nom'];
		
		//Si Super assoc est activé si on change quelques donnés pour l'envoi des mails
		
		if(lire_config('encheres/super_asso')) {
				$datas=array(
					'asso'=>$asso,
					'projet'=>$projet
					);
				include_spip('inc/encheresmail_fonctions');		
				$donnees =donnees_superasso($datas);	
				$asso=$donnees['asso'];
				$projet=$donnees['projet'];	
			}
		


				
		if ($type!='cloture_cron_mise_en_vente'){
					
			$set=array(
				' statut'=>$statut,
				 'date_vente'=>$date,
				 'id_acheteur' => $id_encherisseur
				);

			sql_updateq('spip_encheres_objets',$set,'id_objet='.sql_quote($id_objet));

			sql_updateq('spip_encheres_encherisseurs',array('gagne'=>$gagne),'id_objet='.sql_quote($id_objet).' AND id_encherisseur='.sql_quote($id_encherisseur));	
			
			
		// On assemble les infos pour l'envoi des mails	
		$contexte=array(
			'objet'=>$objet,
			'projet'=>$projet,
			'asso'=>$asso,
			'artobjet'=>$artobjet,	
			'acheteur'=>$acheteur,	
			'kidonateur'=>$kidonateur,
			'commune'=>'rien',	
			'pays_kidonateur'=>'rien',	
			'id_mot_article'=>'rien',	
			);	
			

				
				//Mail de confirmation au gagnant de l'enchère
					$envoyer_message_acheteur = charger_fonction('envoyer_message_acheteur','inc');
 					$envoyer_message_acheteur($email,'enchere_gagnee',$id_objet,$contexte);

					//Mail de confirmation aux perdant de l'enchère
					$sql = sql_select('id_encherisseur','spip_encheres_encherisseurs',array('id_objet='.$id_objet,'gagne!=1','suivre!=1' ));
					
					$id_perdants=array();
					while($perdants = sql_fetch($sql)) {
						$id_perdants[]=$perdants ['id_encherisseur'];
						}
						
					spip_log('action:acheteur -'.serialize($id_perdants),'teste');
								
								
					foreach($id_perdants as $id_perdant){
						$acheteur_perdant=  requete_auteurs_elargis(array('id_auteur='.sql_quote($id_perdant)));
						$email =$acheteur_perdant['email'];						
						$contexte['url_recherche']=$var_url_categories;
						$contexte['acheteur']=$acheteur_perdant;							
						$envoyer_message_acheteur = charger_fonction('envoyer_message_acheteur','inc');
						$envoyer_message_acheteur($email,'enchere_perdu',$id_objet,$contexte);
						}
					
					//Mail de confirmation à l'association
 					$envoyer_message_asso = charger_fonction('envoyer_message_asso','inc');
 					$envoyer_message_asso('','enchere_gagnee_asso',$id_objet,$contexte);
 					
 					//Mail de confirmation au kidonateur
					
					// nom de l'assos origin	en cas de superasso
					if(lire_config('encheres/super_asso')) $contexte['asso']['nom']=$contexte['asso']['nom_asso'];
					
 					$envoyer_message_kidonateur = charger_fonction('envoyer_message_kidonateur','inc');
 					$envoyer_message_kidonateur('','enchere_gagnee_kidonateur',$id_objet,$contexte);

					//Mail d'info au webmaster
 					$envoyer_message_webmestre = charger_fonction('envoyer_message_webmestre','inc');
 					$envoyer_message_webmestre('enchere_gagnee',$id_objet,$id_encherisseur);
					}

		elseif($remise_vente_automatique AND $statut_2!='vendu'){
 			$remettre_en_vente = charger_fonction('remise_vente','inc');
 			$remettre_en_vente($id_objet,'','auto');
			}
		else{
			$statut='non_vendu';
			
			sql_updateq('spip_encheres_objets',array("statut" => $statut),'id_objet='.sql_quote($id_objet));
			
			//Mail de confirmation au kidonateur

				$envoyer_message_kidonateur = charger_fonction('envoyer_message_kidonateur','inc');
				$envoyer_message_kidonateur('','enchere_cloture_sansmise_kidonateur',$id_objet,$contexte);

			};
						
        $id_objet = $id_objet_actuel;
				
				//Enregistre le log
				if ($type == 'cloture_mise_inmediat'){spip_log("Vente inmediate : action cloture de l'enchère: $id_objet",'encheres');};
				if ($type == 'cloture_cron_mise_en_vente_active'){spip_log("CRON : action cloture de l'enchère active: $id_objet",'encheres_cron');};
				if ($type == 'cloture_cron_mise_en_vente'){spip_log("CRON : action cloture de l'enchère sans mises: $id_objet",'encheres_cron');};

						
		// Invalider les caches
	   include_spip('inc/invalideur');
	   suivre_invalideur("id='id_objet/$id_objet'");
								
}
?>