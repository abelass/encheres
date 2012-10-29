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
		
		//Cherche une catégorie de l'objet actuel pour créer le lien recherche pour le mail aux encherisseurs perdants

		if ($type!='cloture_cron_mise_en_vente' AND $type!='cloture_mise_inmediat'){
		
				$id_mot=sql_getfetsel('id_mot','spip_mots_articles',array('id_article='.sql_quote($id_article)));
				$id_groupe=sql_getfetsel('id_groupe','spip_mots',array('id_mot='.sql_quote($id_mot)));
				
 					$mots_groupes = spip_query( "SELECT * FROM spip_groupes_mots WHERE id_groupe='$id_groupe'");
						while($data = sql_fetch($mots_groupes)) {
 						$id_parent = $data['id_parent'];
						$var_url_categories = '&id_groupe1='.$id_groupe.'&recherche_etendue=oui#tableauobjets';

 						$sql1 = spip_query( "SELECT * FROM spip_groupes_mots WHERE id_groupe='$id_parent'");
							while($data = sql_fetch($sql1)) {
 							$id_parent = $data['id_parent'];
							$var_url_categories = '&id_groupe1='.$id_groupe.'&recherche_etendue=oui#tableauobjets';

 							$sql2 = spip_query( "SELECT * FROM spip_groupes_mots WHERE id_groupe='$id_parent'");
								while($data = sql_fetch($sql2)) {
 								$id_parent = $data['id_parent'];
								$var_url_categories = '&id_groupe1='.$id_groupe.'&recherche_etendue=oui#tableauobjets';
 								}
 							}
						}
 						
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
					$sql = sql_select('id_encherisseur','spip_encheres_encherisseurs',array('id_objet='.$id_objet,'gagne=0','suivre!=1' ));
					
					$id_perdants=array();
					while($perdants = sql_fetch($sql)) {
						$id_perdants[]=$perdants ['id_encherisseur'];
						}
						
					spip_log('action:acheteur -'.serialize($id_perdants),'teste 3');
								
								
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
			$statut='vendu';
			
			sql_updateq('spip_encheres_objets',array("statut" => $statut),'id_objet='.sql_quote($id_objet));
			
			//Mail de confirmation au kidonateur

				$envoyer_message_kidonateur = charger_fonction('envoyer_message_kidonateur','inc');
				$envoyer_message_kidonateur('','enchere_cloture_sansmise_kidonateur',$id_objet,$contexte);

			};
						
		//Mise en vente des objets multi
		
		$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE (statut='mise_en_vente' OR statut='mise_en_vente_active') AND id_article='$id_article'  ORDER BY id_objet DESC LIMIT 3");

			while($data = sql_fetch($sql)) {
				$compteur = $compteur+1;
					}
				$sql2 = spip_query( "SELECT * FROM spip_encheres_objets WHERE statut='stand_by'  AND id_article='$id_article'  ORDER BY id_objet DESC LIMIT 1");
					while($data = sql_fetch($sql2)) {
					$duree = $data['duree'];
					$statut = 'mise_en_vente';				
					}
				$date_fin = date('Y-m-d G:i:s', strtotime ($date."$duree day"));
				
				//Dans le cas des objets de la billetterie, vérifie si la date_stop-vente n'est pas inférieure à la date_fin de l'objet, sinon la date_fin devient la date_stop_vente	
						
				if ($date_fin > $date_stop_vente AND $date_stop_vente!="0000-00-00 00:00:00") $date_fin=$date_stop_vente;
				$nombre = 3-$compteur;
				

				if ($date_fin>$date){
				spip_query ("UPDATE spip_encheres_objets SET statut = '$statut', date_debut = '$date', date_fin = '$date_fin'  WHERE statut='stand_by' AND id_article='$id_article' ORDER BY id_objet LIMIT $nombre");
				
				if($nombre>0 AND $compteur!=1){
					$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE statut='mise_en_vente' AND id_article='$id_article'  ORDER BY id_objet DESC LIMIT $nombre");
						while($data = sql_fetch($sql)) {
						$id_objet = $data['id_objet'];
						$statut = 'mise_en_vente_multi';
					
						//Mail d'info au webmaster
 						$envoyer_inscription_webmaster = charger_fonction('envoyer_message_webmaster','inc');
 						$envoyer_inscription_webmaster('mise_en_vente_multi',$id_objet);
						}
					}
				}
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