<?php

//fonction qui crée les sujets et textes les différents emails aux visiteurs/kidonateurs et assos et prépare leur envoi

	if (!defined("_ECRIRE_INC_VERSION")) return;

function inc_envoyer_message_visiteur_dist($email='',$type,$option="",$option2="") {
    include_spip('inc/mail');
	
	// On récupère les données nécessaires à envoyer le mail de validation
	// La fonction envoyer_mail se chargera de nettoyer cela plus tard

	$nom_site_spip = $GLOBALS['meta']["nom_site"];
	$url_site = $GLOBALS['meta']["adresse_site"];
	$spip_lang='fr';
	$nom_site_spip = $GLOBALS['meta']["nom_site"];
	$expediteur = $GLOBALS['meta']["email_webmaster"];			
	$from = $nom_site_spip.'<'.$expediteur.'>';

	//On prépare le infos pour le message et sujet

	$sql = spip_query( "SELECT * FROM spip_auteurs WHERE email='$email'");
	while($data = spip_fetch_array($sql)) {
		$nom =extraire_multi($data['nom']);
		$id_auteur = $data['id_auteur'];
		$sql = spip_query( "SELECT * FROM spip_auteurs_elargis WHERE id_auteur='$id_auteur'");
			while($data = spip_fetch_array($sql)) {
				$prenom = extraire_multi($data['prenom']);
				$nom_famille = extraire_multi($data['nom_famille']);
				$langue = $data['langue'];
				}
		}

	$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$option'");
		while($data = spip_fetch_array($sql)) {
			$id_article = $data['id_article'];
			$duree_mise = $data['duree'];
			$date_debut_evenement = affdate($data['date_debut_evenement'],'d-m-Y');
			$date_fin_evenement=date('d-m-Y', strtotime ($data['date_stop_vente'].' "+13 day"'));
			$date_fin = affdate($data['date_fin'],'d-m-Y G:i:s');
			$date_debut_evenement = affdate($data['date_debut_evenement'],'d/m/Y');			
			$date_fin_evenement = affdate($data['date_fin_evenement'],'d/m/Y');
 			$date_vente = date('d-m-Y',strtotime($data['date_vente']));
 			$validite = $date_debut_evenement.'-'.$date_fin_evenement;
 			if($date_debut_evenement==$date_fin_evenement)$validite=$date_debut_evenement;
 			
			$mode_livraison = $data['mode_livraison'];
			$prix_livraison = $data['prix_livraison'];
			$prix_livraison_etranger = $data['prix_livraison_etranger'];			
			$courrier_velo = $data['courrier_velo'];				
			$montant_mise = $data['montant_mise'];
			$id_auteur = $data['id_auteur'];
			$envoi_rappels = $data['envoi_rappels'];
			$id_acheteur = $data['id_acheteur'];
			$nombre = $data['nombre'];
			$livraison_etranger = $data['livraison_etranger'];			
			$acheteur = spip_query( "SELECT * FROM spip_auteurs WHERE id_auteur='$id_acheteur'");
			
			while($data = spip_fetch_array($acheteur )) {
				$id_acheteur = $data['id_auteur'];			
				$email_acheteur = $data['email'];
				$nom_acheteur = $data['nom'];
				$acheteur_el = spip_query( "SELECT * FROM spip_auteurs_elargis WHERE id_auteur='$id_acheteur'");	
					while($data = spip_fetch_array($acheteur_el)) {
					$prenom_acheteur = $data['prenom'];
					$nom_famille_acheteur = $data['nom_famille'];
					$langue_acheteur = $data['langue'];	
					$pays_acheteur = $data['pays'];										
					}				
				}

				
			$sql = spip_query( "SELECT * FROM spip_auteurs WHERE id_auteur='$id_auteur'");
				while($data = spip_fetch_array($sql)) {
					$nom_kidonateur = extraire_multi($data['nom']);
					$email_kidonateur = $data['email'];

					$sql = spip_query( "SELECT * FROM spip_auteurs_elargis WHERE id_auteur='$id_auteur'");
						while($data = spip_fetch_array($sql)) {
						$prenom_kidonateur = extraire_multi($data['prenom']);
						$nom_famille_kidonateur = extraire_multi($data['nom_famille']);
						$paypal_kidonateur = $data['paypal'];
						$adresse_kidonateur = $data['adresse'];		
						$pays_k = $data['pays'];
						$bic_kidonateur = $data['bic'];																
						$compte_bancaire_kidonateur = 	_T('encheres:compte_bancaire').' : '.$data['compte_bancaire'].' - '
														._T('encheres:bic').' : '.$bic_kidonateur;
						

						$langue_kidonateur = $data['langue'];

						$id_commune = $data['id_commune'];						
						$sql2 = spip_query( "SELECT * FROM spip_mots WHERE id_mot='$id_commune'");
						while($data2 = spip_fetch_array($sql2)) {
							$ville_kidonateur = $data2['titre'];
							$code_postal_kidonateur = $data2['code_postal'];
							}
						$sql3 = spip_query( "SELECT * FROM spip_groupes_mots WHERE id_groupe='$pays_k'");
						while($data3 = spip_fetch_array($sql3)) {
							$pays_kidonateur = $data3['titre'];
							}											
						$adresse_kidonateur = $adresse_kidonateur.', '.$code_postal_kidonateur.' '.$ville_kidonateur.' - '.$pays_kidonateur;	
						}
					}		
					

			$sql = spip_query( "SELECT * FROM spip_articles WHERE id_article='$id_article'");
				while($data = spip_fetch_array($sql)) {
					$titre_article = $data['titre'];
					$id_rubrique = $data['id_rubrique'];
					$commentaire = $data['chapo'];
					
					$sql_bill = spip_query( "SELECT * FROM spip_mots_articles WHERE id_article='$id_article'");
						while($data = spip_fetch_array($sql_bill)) {
						$id_mot= $data['id_mot'];
						$billet = spip_query( "SELECT * FROM spip_mots WHERE id_mot='$id_mot' AND id_groupe='80'");
							while($data = spip_fetch_array($billet)) {
							$id_groupe= $data['id_groupe'];
							$billetterie='ok';
							}						
						}

					$sql = spip_query( "SELECT * FROM spip_rubriques WHERE id_rubrique='$id_rubrique'");
						while($data = spip_fetch_array($sql)) {
    						$titre_rubrique = $data['titre']; 
						$id_auteur_rubrique = $data['id_auteur'];
						$compte_bancaire_projet = $data['compte_bancaire'];
						$communication_virement_projet = $data['communication_virement'];
							$sql = spip_query( "SELECT * FROM spip_auteurs WHERE id_auteur='$id_auteur_rubrique'");
								while($data = spip_fetch_array($sql)) {
								$nom_asso = $data['nom'];
								$id_auteur_asso = $data['id_auteur'];
								$email_asso = $data['email'];
								if ($type=='enchere_gagnee'  OR $type=='rappel_acheteur' OR $type=='enchere_gagnee_asso' OR $type=='rappel_asso'){
									$sql2 = spip_query( "SELECT * FROM spip_auteurs_elargis WHERE id_auteur='$id_auteur_asso'");
									while($data = spip_fetch_array($sql2)) {
										$prenom_asso = extraire_multi($data['prenom']);
										$nom_famille_asso = extraire_multi($data['nom_famille']);
										$compte_bancaire_asso = $data['compte_bancaire'];
										$communication_virement_asso = $data['communication_virement'];
										$adresse_asso = extraire_multi($data['adresse']);
										$code_postal_asso = $data['code_postal'];
										$ville_asso = extraire_multi($data['ville']);
										$paypal_asso	 = extraire_multi($data['paypal']);
										$langue_asso = $data['langue'];
										$adresse_asso = $adresse_asso.', '.$code_postal_asso.' '.$ville_asso;
										if($compte_bancaire_projet){$compte_bancaire_asso=$compte_bancaire_projet;}
										if($communication_virement_projet){$communication_virement_asso=$communication_virement_projet;}
										if(!$communication_virement_asso){$communication_virement_asso='kidonaki';}
										}	
									}
								}
							}
						}
				}

		// Détermine le prix de livraison, nationale ou étranger
		
		if ($pays_acheteur != $pays_k AND $livraison_etranger) {$prix_livraison =$prix_livraison_etranger;}
		if ($billetterie) $html='oui';		
		

	// mail de confirmation de mise en vente

	if ($type=='mettre_en_vente'){
			if ($langue) lang_select($langue);
			if ($nombre > 1) {$message_nombre = "\n"._T('encheres:message_specifique_nombre',array('nombre' => $nombre));}
			$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_mise_vente_objet_sujet');
			$message = _T('bonjour').' '. $prenom.' '. $nom_famille."\n\n"
				. _T('encheres:email_mise_vente_objet_message', array('titre_article' => $titre_article, 'id_objet' => $option,'message_nombre' => $message_nombre,'duree_mise' => $duree_mise,'titre_rubrique' => extraire_multi($titre_rubrique),'nom_asso' => extraire_multi($nom_asso)))."\n\n"
				. _T('encheres:email_signature')."\n\n"._T('message_auto');	
			}

	// mail de confirmation pour après une mise aux enchère réussi

	elseif ($type=='enchere_reussie') {
			if ($langue) lang_select($langue);
			$lang = 'en';
			$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_encherisseur_enchere_reussi_sujet');
			$message =_T('bonjour').' '. $prenom.' '. $nom_famille."\n\n"
				. _T('encheres:email_encherisseur_enchere_reussi_objet_message', array('titre_article' => $titre_article, 'id_objet' => $option,'date_fin' => $date_fin,'titre_rubrique' => extraire_multi($titre_rubrique)))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	

			}

	// mail de confirmation pour l'enchérisseur surpassé

	elseif ($type=='enchere_surpassee') {
		if ($langue) lang_select($langue);
		$url_enchere= generer_url_public("article","id_article=$id_article");
		$url_enchere= str_replace('&amp;','&',$url_enchere); 
		$url_var='&id_objet='.$option.'&enchere=encherir';
		$url_enchere = $url_enchere.$url_var;
		$url_bouton = $url_site.'/squelettes/styles/images/encherir.jpg';

			$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_encherisseur_surpasse_sujet');
			$message =_T('bonjour').' '. $prenom.' '. $nom_famille."\n\n"
				. _T('encheres:email_encherisseur_surpasse_objet_message', array('titre_article' => $titre_article, 'id_objet' => $option,'date_fin' => $date_fine,'titre_rubrique' => extraire_multi($titre_rubrique),'url_enchere' => $url_enchere,'url_bouton' => $url_bouton,'nom_asso' => extraire_multi($nom_asso)))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	

			}

	// mail de confirmation pour l'enchérisseur surpassé - suiveur, avis des 24 heures

	elseif ($type=='avis_24_heures') {
		if ($langue) lang_select($langue);
		$url_enchere= generer_url_public("article","id_article=$id_article");
		$url_enchere= str_replace('&amp;','&',$url_enchere); 
		$url_var='&id_objet='.$option.'&enchere=encherir';
		$url_enchere = $url_enchere.$url_var;
		$url_bouton = $url_site.'/squelettes/styles/images/encherir.jpg';

			$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_suiveur_avis_24_heures_sujet');
			$message =_T('bonjour').' '. $prenom.' '. $nom_famille."\n\n"
				. _T('encheres:email_suiveur_avis_24_heures_objet_message', array('titre_article' => $titre_article, 'id_objet' => $option,'titre_rubrique' => extraire_multi($titre_rubrique),'url_enchere' => $url_enchere,'url_bouton' => $url_bouton,'nom_asso' => extraire_multi($nom_asso)))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');
			}
			
	// mail de d'avertissment 24 heures avant remise en vente automatique

	elseif ($type=='avis_24_heures_remise_auto') {
		if ($langue_kidonateur) lang_select($langue_kidonateur);
			$email=$email_kidonateur;
			$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_avis_24_heures_remise_auto_sujet');
			$message =_T('bonjour').' '. $prenom_kidonateur.' '. $nom_famille_kidonateur."\n\n"
				. _T('encheres:email_avis_24_heures_remise_auto_message', array('titre_article' => $titre_article, 'id_objet' =>$option))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');
			}
	// mail de confirmation pour l'enchérisseur qui a emporté l'enchère

	elseif ($type=='enchere_gagnee') {
		$url_paiement= generer_url_public("paiement",'','false');

		if ($langue) lang_select($langue);
		
		if ($courrier_velo) {
			$url_article = generer_url_public("article","id_article=1275",'false');
			$message_courrier = "\n\n"._T('encheres:email_courrier_velo',array('url_article' => $url_article));
			}

		if($paypal_asso){
		$url_var_objet='&id_objet='.$id_objet.'&paiement=objet&mode_paiement=paypal';
		$url_paiement_objet = $url_paiement.$url_var_objet;
		 $message_paypal_asso = "\n\n"._T('encheres:email_enchere_gagnee_message_paypal_asso',array('paypal_asso' => $paypal_asso,'url_paiement_objet' => $url_paiement_objet));
			}

		if($paypal_kidonateur){
		$url_var_frais='&id_objet='.$id_objet.'&paiement=frais&mode_paiement=paypal';
		$url_paiement_frais = $url_paiement.$url_var_frais;
 		$message_paypal_kidonateur = "\n\n"._T('encheres:email_enchere_gagnee_message_paypal_kidonateur',array('paypal_asso' => $paypal_asso,'url_paiement_frais' => $url_paiement_frais));
			}

		if ($mode_livraison == 'email') {$message_specifique = _T('encheres:email_enchere_gagnee_message_specifique_email',array('titre_article' => $titre_article,'communication_virement' => $communication_virement_asso,'montant_mise' => $montant_mise, 'id_objet' => $option,'adresse_asso' => $adresse_asso,'compte_bancaire_asso' => $compte_bancaire_asso,'nom_asso' => extraire_multi($nom_asso),'message_paypal_asso' => $message_paypal_asso,'date_debut' => $date_debut_evenement,'date_fin' => $date_fin_evenement)).$message_courrier;}

		elseif ($mode_livraison == 'venir' OR $prix_livraison=='0') {$message_specifique = _T('encheres:email_enchere_gagnee_message_specifique_venir',array('titre_article' => $titre_article,'communication_virement' => $communication_virement_asso,'montant_mise' => $montant_mise, 'id_objet' => $option,'adresse_asso' => $adresse_asso,'compte_bancaire_asso' => $compte_bancaire_asso,'nom_asso' => extraire_multi($nom_asso),'message_paypal_asso' => $message_paypal_asso)).$message_courrier;}

		elseif ($mode_livraison == 'livraison' OR $mode_livraison == 'poste') {
		 $message_specifique = _T('encheres:email_enchere_gagnee_message_specifique_livraison',array('titre_article' => $titre_article,'communication_virement' => $communication_virement_asso,'montant_mise' => $montant_mise, 'id_objet' => $option,'adresse_asso' => $adresse_asso,'compte_bancaire_asso' => $compte_bancaire_asso,'nom_asso' => extraire_multi($nom_asso),'adresse_kidonateur' => $adresse_kidonateur,'compte_bancaire_kidonateur' => $compte_bancaire_kidonateur,'prix_livraison' => $prix_livraison,'message_paypal_asso' => $message_paypal_asso,'message_paypal_kidonateur' => $message_paypal_kidonateur,'nom_kidonateur' => $nom_kidonateur,'prix_transport' => $prix_livraison,'ville_kidonateur' => $ville_kidonateur)).$message_courrier;}

		elseif ($mode_livraison == 'posteouvenir') {$message_specifique = _T('encheres:email_enchere_gagnee_message_specifique_posteouvenir',array('titre_article' => $titre_article,'communication_virement' => $communication_virement_asso,'montant_mise' => $montant_mise, 'id_objet' => $option,'adresse_asso' => $adresse_asso,'compte_bancaire_asso' => $compte_bancaire_asso,'nom_asso' => extraire_multi($nom_asso),'adresse_kidonateur' => $adresse_kidonateur,'compte_bancaire_kidonateur' => $compte_bancaire_kidonateur,'prix_livraison' => $prix_livraison,'message_paypal_asso' => $message_paypal_asso,'message_paypal_kidonateur' => $message_paypal_kidonateur,'email_kidonateur' => $email_kidonateur,'ville_kidonateur' => $ville_kidonateur,'nom_kidonateur' => $nom_kidonateur,'prix_transport' => $prix_livraison,'email_kidonateur' => $email_kidonateur)).$message_courrier;};

			$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_enchere_gagnee_sujet');
			$message =_T('bonjour').' '. $prenom.' '. $nom_famille."\n\n"
				. _T('encheres:email_enchere_gagnee_objet_message', array('titre_article' => $titre_article, 'id_objet' => $option,'date_fin' => $date_fin,'titre_rubrique' => extraire_multi($titre_rubrique),'nom_asso' => extraire_multi($nom_asso),'message_specifique' => $message_specifique))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	

			}

	// mail de confirmation pour les enchérisseur qui ont perdu l'enchère

	elseif ($type=='enchere_perdu') {
		if ($langue) lang_select($langue);
		$url_recherche= generer_url_public("achat");
		$url_recherche= str_replace('&amp;','&',$url_recherche); 
		$url_recherche= $url_recherche.$option2; 

			$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_enchere_perdu_sujet');
			$message =_T('bonjour').' '. $prenom.' '. $nom_famille."\n\n"
				. _T('encheres:email_enchere_perdu_objet_message', array('titre_article' => $titre_article, 'id_objet' => $option,'url_recherche' => $url_recherche))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	

		}

	// mail de confirmation pour l'asociation bénéficiaire de la vente après la fin de l'enchère

	elseif ($type=='enchere_gagnee_asso') {
		if ($langue_asso) lang_select($langue_asso);
		$email = $email_asso;
		$url_kidonateur= generer_url_public("auteur","id_auteur=$id_auteur_asso");
		$url_kidonateur= str_replace('&amp;','&',$url_kidonateur); 
		$url_kidonateur= $url_kidonateur; 
		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_asso_enchere_gagne_sujet');
		$message =_T('bonjour').' '. $prenom_asso.' '. $nom_famille_asso."\n\n"
				. _T('encheres:email_asso_enchere_gagne_objet_message', array('titre_article' => $titre_article, 'id_objet' => $option,'montant_mise' => $montant_mise,'compte_bancaire_asso' => $compte_bancaire_asso,'titre_rubrique' => extraire_multi($titre_rubrique),'url_kidonateur' => $url_kidonateur,'communication_virement' => $communication_virement_asso))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	

		}

	// mail de confirmation pour le kidonateur après la fin de l'enchère avec acheteur

	elseif ($type=='enchere_gagnee_kidonateur') {
		if ($langue_kidonateur) lang_select($langue_kidonateur);
		$email = $email_kidonateur;
		
		if ($mode_livraison == 'venir' OR $prix_livraison=='0') {
		$message_specifique = '';}

		elseif ($mode_livraison == 'livraison' OR $mode_livraison == 'poste') {
		$message_specifique = _T('encheres:email_kidonateur_enchere_gagnee_message_specifique_livraison');}

		elseif ($mode_livraison == 'posteouvenir') {
		$message_specifique = _T('encheres:email_kidonateur_enchere_gagnee_message_specifique_posteouvenir');};

		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_kidonateur_enchere_gagnee_sujet');
		$message =_T('bonjour').' '. $prenom_kidonateur.' '. $nom_famille_kidonateur."\n\n"
				. _T('encheres:email_kidonateur_enchere_gagnee_objet_message', array('titre_article' => $titre_article, 'id_objet' => $option,'montant_mise' => $montant_mise,'titre_rubrique' => extraire_multi($titre_rubrique),'nom_asso' => extraire_multi($nom_asso),'message_specifique' => $message_specifique))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	
			}

	// mail de confirmation pour le kidonateur de la vente après la fin de l'enchère sans acheteur

	elseif ($type=='enchere_cloture_sansmise_kidonateur') {
	
		if ($langue_kidonateur) lang_select($langue_kidonateur);
		$email = $email_kidonateur;
		$url_kidonateur= "/spip.php?page=auteur&id_auteur=".$id_auteur.'&remise_vente=oui&id_objet='.$option;
		$url_kidonateur= $url_site.$url_kidonateur; 
		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_kidonateur_enchere_sansmise_sujet');
		$message =_T('bonjour').' '. $prenom_kidonateur.' '. $nom_famille_kidonateur."\n\n"
				. _T('encheres:email_kidonateur_enchere_sansmise_objet_message', array('titre_article' => $titre_article, 'id_objet' => $option,'titre_rubrique' => extraire_multi($titre_rubrique),'url_kidonateur' => $url_kidonateur))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	

		}

	// Rappel pour l'acheteur paiement non enregistré
	elseif ($type=='rappel_acheteur') {

		$url_paiement= generer_url_public("paiement");
		$url_paiement= str_replace('&amp;','&',$url_paiement); 
		
		if ($langue) lang_select($langue);
		
		if ($courrier_velo) {
			$url_article = generer_url_public("article","&id_article=1275",false);
			$message_courrier = "\n\n"._T('encheres:email_courrier_velo',array('url_article' => $url_article));
			}

		if($paypal_asso){
		$url_var_objet='&id_objet='.$id_objet.'&paiement=objet&mode_paiement=paypal';
		$url_paiement_objet = $url_paiement.$url_var_objet;
		 $message_paypal_asso = "\n\n"._T('encheres:email_enchere_gagnee_message_paypal_asso',array('paypal_asso' => $paypal_asso,'url_paiement_objet' => $url_paiement_objet));
			}

		if($paypal_kidonateur){
		$url_var_frais='&id_objet='.$id_objet.'&paiement=frais&mode_paiement=paypal';
		$url_paiement_objet = $url_paiement.$url_var_frais;
 		$message_paypal_kidonateur = "\n\n"._T('encheres:email_enchere_gagnee_message_paypal_kidonateur',array('paypal_asso' => $paypal_asso,'url_paiement_frais' => $url_paiement_frais));
			}

		if ($mode_livraison == 'venir' OR $prix_livraison=='0') {
		$message_specifique = _T('encheres:email_enchere_gagnee_message_specifique_venir',array('titre_article' => $titre_article,'communication_virement' => $communication_virement_asso,'montant_mise' => $montant_mise, 'id_objet' => $option,'adresse_asso' => $adresse_asso,'compte_bancaire_asso' => $compte_bancaire_asso,'nom_asso' => extraire_multi($nom_asso),'message_paypal_asso' => $message_paypal_asso)).$message_courrier;}

		elseif ($mode_livraison == 'livraison' OR $mode_livraison == 'poste') {
		 $message_specifique = _T('encheres:email_enchere_gagnee_message_specifique_livraison',array('montant_mise' => $montant_mise,'titre_article' => $titre_article,'communication_virement' => $communication_virement_asso, 'id_objet' => $option,'adresse_asso' => $adresse_asso,'compte_bancaire_asso' => $compte_bancaire_asso,'nom_asso' => extraire_multi($nom_asso),'adresse_kidonateur' => $adresse_kidonateur,'compte_bancaire_kidonateur' => $compte_bancaire_kidonateur,'prix_livraison' => $prix_livraison,'message_paypal_asso' => $message_paypal_asso,'message_paypal_kidonateur' => $message_paypal_kidonateur,'nom_kidonateur' => $nom_kidonateur,'prix_transport' => $prix_livraison,'ville_kidonateur' => $ville_kidonateur)).$message_courrier;}

		elseif ($mode_livraison == 'posteouvenir') {
		$message_specifique = _T('encheres:email_enchere_gagnee_message_specifique_posteouvenir',array('montant_mise' => $montant_mise,'titre_article' => $titre_article,'communication_virement' => $communication_virement_asso, 'id_objet' => $option,'adresse_asso' => $adresse_asso,'compte_bancaire_asso' => $compte_bancaire_asso,'nom_asso' => extraire_multi($nom_asso),'adresse_kidonateur' => $adresse_kidonateur,'compte_bancaire_kidonateur' => $compte_bancaire_kidonateur,'prix_livraison' => $prix_livraison,'message_paypal_asso' => $message_paypal_asso,'message_paypal_kidonateur' => $message_paypal_kidonateur,'email_kidonateur' => $email_kidonateur,'ville_kidonateur' => $ville_kidonateur,'nom_kidonateur' => $nom_kidonateur,'prix_transport' => $prix_livraison,'email_kidonateur' => $email_kidonateur)).$message_courrier;};
		
		$sujet = _T('encheres:email_rappel_acheteur_sujet');
		if($envoi_rappels == 15) $sujet = _T('encheres:email_rappel_2_acheteur_sujet');
		if($envoi_rappels == 21) $sujet = _T('encheres:email_rappel_3_acheteur_sujet');

			$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : ".$sujet;
			$message =_T('bonjour').' '. $prenom.' '. $nom_famille."\n\n"
				. _T('encheres:email_rappel_acheteur_message', array('titre_article' => $titre_article, 'id_objet' => $option,'date_vente' => $date_vente,'titre_rubrique' => extraire_multi($titre_rubrique),'nom_asso' => extraire_multi($nom_asso),'message_specifique' => $message_specifique))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	

			}
	// Avis au vendeur l'informant des rappels envoyés 
	elseif ($type=='rappel_vendeur') {
		if ($langue_kidonateur) lang_select($langue_kidonateur);
		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_rappel_vendeur_sujet');
		$message =_T('bonjour').' '. $prenom_kidonateur.' '. $nom_famille_kidonateur."\n\n"
				. _T('encheres:email_rappel_vendeur_message', array('titre_article' => $titre_article, 'id_objet' => $option,'date_vente' => $date_vente,'titre_rubrique' => extraire_multi($titre_rubrique),'nom_asso' => extraire_multi($nom_asso),'prenom_acheteur' => $prenom,'nom_famille_acheteur' => $nom_famille,'email_acheteur' => $email))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');
		$email = $email_kidonateur;	
			}

	// Avis à l'association, vérification paiement

	elseif ($type=='rappel_asso') {
		if ($langue_asso) lang_select($langue_asso);
		$email = $email_asso;
		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_rappel_asso_sujet');
		$message =_T('bonjour').' '. $prenom_asso.' '. $nom_famille_asso."\n\n"
				. _T('encheres:email_rappel_asso_message', array('titre_article' => $titre_article, 'id_objet' => $option,'date_vente' => $date_vente,'compte_bancaire_asso' => $compte_bancaire_asso,'titre_rubrique' => extraire_multi($titre_rubrique),'url_kidonateur' => $url_kidonateur,'prenom_acheteur' => $prenom,'nom_famille_acheteur' => $nom_famille))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	
			}
			
	// Email au vendeur si pas de paiement enregistré et possibilité de remetre en vente 
	elseif ($type=='remise_en_vente_vendeur') {
		if ($langue_kidonateur) lang_select($langue_kidonateur);
		$url_kidonateur= "/spip.php?page=auteur&id_auteur=".$id_auteur.'&remise_vente=oui&id_objet='.$option;
		$url_remise= $url_site.$url_kidonateur; 
		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_remise_en_vente_vendeur_sujet');
		$message =_T('bonjour').' '. $prenom_kidonateur.' '. $nom_famille_kidonateur."\n\n"
				. _T('encheres:email_remise_en_vente_vendeur_message', array('titre_article' => $titre_article, 'id_objet' => $option,'date_vente' => $date_vente,'titre_rubrique' => extraire_multi($titre_rubrique),'nom_asso' => extraire_multi($nom_asso),'prenom_acheteur' => $prenom,'nom_famille_acheteur' => $nom_famille,'url_remise' => $url_remise))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');
		$email = $email_kidonateur;	
			}
				
	// Email au encherisseurs perdants si pas de paiement enregistré et objet remis en vente 
	elseif ($type=='remise_en_vente_sans_payer') {
		if ($langue) lang_select($langue);
		$url_enchere= generer_url_public("article","id_article=$id_article");
		$url_enchere= str_replace('&amp;','&',$url_enchere); 
		$url_var='&id_objet='.$option.'&enchere=encherir';
		$url_enchere = $url_enchere.$url_var;
		$sujet = _T('encheres:email_remise_en_vente_sans_payer_encherisseurs_sujet',array('titre_article' => $titre_article, 'id_objet' => $option));
		$message =_T('bonjour').' '. $prenom.' '. $nom_famille."\n\n"
				. _T('encheres:email_remise_en_vente_sans_payer_encherisseurs_message', array('titre_article' => $titre_article, 'id_objet' => $option,'date_vente' => $date_vente,'prenom_acheteur' => $prenom_acheteur,'nom_famille_acheteur' => $nom_famille_acheteur,'nom_kidonateur' => $nom_kidonateur,'nom_famille_kidonateur' => $nom_famille_kidonateur,'url_enchere' => $url_enchere))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');
			}
						
	// Avis au vendeur de la réception du paiement
	elseif ($type=='paiement_ok_kidonateur') {
	
		if ($langue_kidonateur) lang_select($langue_kidonateur);
		$url_mon_kido=	generer_url_public('auteur',"id_auteur=$id_auteur",'false');
		$url_projet=generer_url_public('rubrique',"id_rubrique=$id_rubrique",'false');

		if ($mode_livraison == 'email') {$message_specifique = _T('encheres:email_paiement_ok_kidonateur_message_specifique_email');}

		elseif ($mode_livraison == 'venir' OR $prix_livraison=='0') {$message_specifique = _T('encheres:email_paiement_ok_kidonateur_message_specifique_venir');}

		elseif ($mode_livraison == 'livraison' OR $mode_livraison == 'poste') { $message_specifique = _T('encheres:email_paiement_ok_kidonateur_message_specifique_livraison');}

		elseif ($mode_livraison == 'posteouvenir') {$message_specifique = _T('encheres:email_paiement_ok_kidonateur_message_specifique_posteouvenir');};

		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_paiement_ok_kidonateur_sujet');
		$message =_T('bonjour').' '. $prenom_kidonateur.' '. $nom_famille_kidonateur."\n\n"
				. _T('encheres:email_paiement_ok_kidonateur_message', array('titre_article' => $titre_article, 'id_objet' => $option,'titre_rubrique' => extraire_multi($titre_rubrique),'nom_asso' => extraire_multi($nom_asso),'prenom_acheteur' => $prenom_acheteur,'nom_famille_acheteur' => $nom_famille_acheteur,'email_acheteur' => $email_acheteur,'message_specifique' => $message_specifique,'url_kido' => $url_mon_kido,'url_projet' => $url_projet))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');
		$email = $email_kidonateur;	
			}

	// Avis à l'acheteur
	elseif ($type=='paiement_ok_acheteur') {
		$intro_billetterie='';
		if ($langue) lang_select($langue);
		$url_paiement= generer_url_public("paiement",'','false');
		
		if ($courrier_velo) {
			$url_article = generer_url_public("article","&id_article=1275",false);
			$message_courrier = "\n\n"._T('encheres:email_courrier_velo',array('url_article' => $url_article));
			if($billetterie) $message_courrier = "\n\n"._T('encheres:email_courrier_velo_html',array('url_article' => $url_article)); 
			}
		
		if($paypal_kidonateur){
		$url_var_frais='&id_objet='.$id_objet.'&paiement=frais&mode_paiement=paypal';
		$url_paiement_objet = $url_paiement.$url_var_frais;
 		$message_paypal_kidonateur = "\n\n"._T('encheres:email_enchere_gagnee_message_paypal_kidonateur',array('paypal_asso' => $paypal_asso,'url_paiement_frais' => $url_paiement_frais));
 			if ($billetterie) $message_paypal_kidonateur = "\n\n"._T('encheres:email_enchere_gagnee_message_paypal_kidonateur_html',array('paypal_asso' => $paypal_asso,'url_paiement_frais' => $url_paiement_frais));
			}

		
		if ($mode_livraison == 'email') {
		$message_specifique = _T('encheres:email_paiement_ok_acheteur_message_specifique_email',array('id_objet' => $option,'email_kidonateur' => $email_kidonateur,'prenom_kidonateur' => $prenom_kidonateur,'nom_famille_kidonateur' => $nom_famille_kidonateur,'commentaire' => $commentaire)).$message_courrier;
			if ($billetterie) {
					 $message_specifique = _T('encheres:email_paiement_ok_acheteur_message_specifique_email_html',array('id_objet' => $option,'email_kidonateur' => $email_kidonateur,'prenom_kidonateur' => $prenom_kidonateur,'nom_famille_kidonateur' => $nom_famille_kidonateur,'commentaire' => $commentaire,'nom_lieu' => extraire_multi($nom_kidonateur),'validite' => $validite)).$message_courrier;
				}
			}

		elseif ($mode_livraison == 'venir' OR $prix_livraison=='0') {
		$message_specifique = _T('encheres:email_paiement_ok_acheteur_message_specifique_venir',array('id_objet' => $option,'email_kidonateur' => $email_kidonateur,'prenom_kidonateur' => $prenom_kidonateur,'nom_famille_kidonateur' => $nom_famille_kidonateur)).$message_courrier;
			if ($billetterie) $message_specifique  = _T('encheres:email_paiement_ok_acheteur_message_specifique_venir_html',array('id_objet' => $option,'email_kidonateur' => $email_kidonateur,'prenom_kidonateur' => $prenom_kidonateur,'nom_famille_kidonateur' => $nom_famille_kidonateur)).$message_courrier;
			}

		elseif ($mode_livraison == 'livraison' OR $mode_livraison == 'poste') {
		 $message_specifique = _T('encheres:email_paiement_ok_acheteur_message_specifique_livraison',array('adresse_kidonateur' => $adresse_kidonateur,'compte_bancaire_kidonateur' => $compte_bancaire_kidonateur,'prix_livraison' => $prix_livraison,'message_paypal_kidonateur' => $message_paypal_kidonateur,'prenom_kidonateur' => $prenom_kidonateur,'nom_famille_kidonateur' => $nom_famille_kidonateur,'prix_transport' => $prix_livraison,'ville_kidonateur' => $ville_kidonateur,'adresse_kidonateur' => $adresse_kidonateur)).$message_courrier;
		 	if ($billetterie) $message_specifique = _T('encheres:email_paiement_ok_acheteur_message_specifique_livraison_html',array('adresse_kidonateur' => $adresse_kidonateur,'compte_bancaire_kidonateur' => $compte_bancaire_kidonateur,'prix_livraison' => $prix_livraison,'message_paypal_kidonateur' => $message_paypal_kidonateur,'prenom_kidonateur' => $prenom_kidonateur,'nom_famille_kidonateur' => $nom_famille_kidonateur,'prix_transport' => $prix_livraison,'ville_kidonateur' => $ville_kidonateur,'adresse_kidonateur' => $adresse_kidonateur)).$message_courrier;
		 	}

		elseif ($mode_livraison == 'posteouvenir') {
		$message_specifique = _T('encheres:email_paiement_ok_acheteur_message_specifique_posteouvenir',array('prenom_kidonateur' => $prenom_kidonateur,'nom_famille_kidonateur' => $nom_famille_kidonateur,'adresse_kidonateur' => $adresse_kidonateur,'compte_bancaire_kidonateur' => $compte_bancaire_kidonateur,'prix_livraison' => $prix_livraison,'message_paypal_kidonateur' => $message_paypal_kidonateur,'email_kidonateur' => $email_kidonateur,'ville_kidonateur' => $ville_kidonateur,'prix_transport' => $prix_livraison)).$message_courrier;
			if ($billetterie) $message_specifique = _T('encheres:email_paiement_ok_acheteur_message_specifique_posteouvenir_html',array('prenom_kidonateur' => $prenom_kidonateur,'nom_famille_kidonateur' => $nom_famille_kidonateur,'adresse_kidonateur' => $adresse_kidonateur,'compte_bancaire_kidonateur' => $compte_bancaire_kidonateur,'prix_livraison' => $prix_livraison,'message_paypal_kidonateur' => $message_paypal_kidonateur,'email_kidonateur' => $email_kidonateur,'ville_kidonateur' => $ville_kidonateur,'prix_transport' => $prix_livraison)).$message_courrier;
			};
		
		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_paiement_ok_acheteur_sujet');
		$message = _T('bonjour').' '. $prenom_acheteur.' '. $nom_famille_acheteur."\n\n"
				. _T('encheres:email_paiement_ok_acheteur_message', array('titre_article' => $titre_article, 'id_objet' => $option,'titre_rubrique' => extraire_multi($titre_rubrique),'titre_rubrique' => extraire_multi($titre_rubrique),'nom_asso' => extraire_multi($nom_asso),'message_specifique' => $message_specifique))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	
		$email=$email_acheteur;
				if ($billetterie) {$message ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">'
				.recuperer_fond('inc/inc-email_head_html').
				'<body>
					<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  						<tr>
    							<td><img src="http://www.kidonaki.be/newsletter/billetterie/topBilletterie.jpg" alt="Kidonaki" width="750" height="153" /></td>
 						</tr>
  						<tr>
    							<td height="26" background="fondTitre.jpg"><img src="http://www.kidonaki.be/newsletter/billetterie/TitreBilletterie.jpg" width="750" height="29" /></td>
  						</tr>
  						<tr>
    							<td>
    							<table width="750" border="0" cellspacing="0" cellpadding="5">
      							<tr>
        							<td bgcolor="#FFFFFF">
        								<table width="100%" border="0" cellspacing="0" cellpadding="10">
            									<tr>
              										<td>							
				<p class="style6">'._T('encheres:email_intro_billetterie_html',array('id_objet' => $option)).'</p>
				<p>
				<span class="style11">'
				._T('bonjour').' '. $prenom_acheteur.' '. $nom_famille_acheteur.
					'</span></p>'
				. _T('encheres:email_paiement_ok_acheteur_message_html', array('titre_article' => $titre_article, 'id_objet' => $option,'titre_rubrique' => extraire_multi($titre_rubrique),'titre_rubrique' => extraire_multi($titre_rubrique),'nom_asso' => extraire_multi($nom_asso),'message_specifique' => $message_specifique)). _T('encheres:email_signature_html').'<p class="style11">'._T('message_auto').'</p>'
				.'              					</td>
										</tr>
          								</table>
          							</td>
      							</tr>
      
    							</table>
    							</td>
  						</tr>
					</table>
				<div align="center"><img src="http://www.kidonaki.be/newsletter/billetterie/foot.jpg" alt="Kidonaki" width="750" height="40" />
  				<br />
				<span class="style2"><br />
				Kidonaki - <a href="http://www.kidonaki.be" target="_blank">www.kidonaki.be</a> - <a href="mailto:info@kidonaki.be">info@kidonaki.be</a></span></div>
				</body>
			</html>';
			$header ="Content-Type: text/html; charset=UTF-8\n".
				"Content-Transfer-Encoding: 8bit\n" .
				"MIME-Version: 1.0\n";
			}
		$email=$email_acheteur;
			}
			
	// Rappel aux vendeur si objet pas livé 5 jours après réception du paiement
	elseif ($type=='rappel_vendeur_livraison'){
		if ($langue_kidonateur) lang_select($langue_kidonateur);
		$email = $email_kidonateur;
		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_kidonateur_rappel_vendeur_sujet');
		$message =_T('bonjour').' '. $prenom_kidonateur.' '. $nom_famille_kidonateur."\n\n"
				. _T('encheres:email_kidonateur_rappel_vendeur_message', array('titre_article' => $titre_article, 'id_objet' => $option,'titre_rubrique' => extraire_multi($titre_rubrique),'nom_asso' => extraire_multi($nom_asso),'nom_acheteur' => $nom_acheteur,'email_acheteur' => $email_acheteur))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	
		}
		
	// Envoi mail à l'acheteur, si 5 jours après livraison enregistrés celle ci n'a pas été déclaré comme reçu	
	elseif ($type=='rappel_acheteur_recu'){
		if ($langue) lang_select($langue);
		$url_kidonateur= generer_url_public("auteur","id_auteur=$id_acheteur");
		$url_kidonateur= str_replace('&amp;','&',$url_kidonateur); 
		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_kidonateur_rappel_acheteur_recu_sujet');
		$message =_T('bonjour').' '. $prenom.' '. $nom_famille."\n\n"
				. _T('encheres:email_kidonateur_rappel_acheteur_recu_message', array('titre_article' => $titre_article, 'id_objet' => $option,'titre_rubrique' => extraire_multi($titre_rubrique),'nom_asso' => extraire_multi($nom_asso),'prenom_kidonateur' => $prenom_kidonateur,'nom_kidonateur' => $nom_famille_kidonateur,'email_kidonateur' => $email_kidonateur,'url_kido' => $url_kidonateur))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	
		}	
			
	// Envoi mail à l'acheteur, quand le paiement des frais de transport a été enregistré
	
	elseif ($type=='paiement_livraison_ok_acheteur'){
		if ($langue_acheteur) lang_select($langue_acheteur);
		$email=$email_acheteur;
		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_paiement_livraison_ok_sujet');
		$message =_T('bonjour').' '. $prenom_acheteur.' '. $nom_famille_acheteur."\n\n"
				. _T('encheres:email_acheteur_paiement_livraison_ok_message', array('titre_article' => $titre_article, 'id_objet' => $option,'date_vente'=> $date_vente,'titre_rubrique' => extraire_multi($titre_rubrique),'email_kidonateur' => $email_kidonateur))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	
		}	

	// Envoi mail au kidonateur, quand le paiement des frais de transport a été enregistré
	elseif ($type=='paiement_livraison_ok_vendeur'){
		if ($langue_kidonateur) lang_select($langue_kidonateur);
		$email=$email_kidonateur;
		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_paiement_livraison_ok_sujet');
		$message =_T('bonjour').' '. $prenom_kidonateur.' '. $nom_famille_kidonateur."\n\n"
				. _T('encheres:email_vendeur_paiement_livraison_ok_message', array('titre_article' => $titre_article, 'id_objet' => $option,'nom_famille_acheteur' => $nom_famille_acheteur,'prenom_acheteur' => $prenom_acheteur,'titre_rubrique' => extraire_multi($titre_rubrique),'email_acheteur' => $email_acheteur))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	
		}	

	// Envoi mail au kidonateur, quand le la réception de l'objet a été enregistré
	elseif ($type=='objet_recu_kidonateur'){
		if ($langue_kidonateur) lang_select($langue_kidonateur);
		$email=$email_kidonateur;
		$sujet = "[".$nom_site_spip."] - ".$titre_article."(".$option.") : "._T('encheres:email_objet_recu_kidonateur_sujet');
		$message =_T('bonjour').' '. $prenom_kidonateur.' '. $nom_famille_kidonateur."\n\n"
				. _T('encheres:email_objet_recu_kidonateur_message', array('titre_article' => $titre_article, 'id_objet' => $option,'nom_famille_acheteur' => $nom_famille_acheteur,'prenom_acheteur' => $prenom_acheteur,'titre_rubrique' => extraire_multi($titre_rubrique),'montant_mise' => $montant_mise,'nom_asso' => extraire_multi($nom_asso)))."\n\n". _T('encheres:email_signature')."\n\n"._T('message_auto');	
		}						
	// Notifications de questions/réponses 

	elseif ($type=='reponse_forum_objet' OR $type=='question_forum_auteur_article') {
		if ($langue) lang_select($langue);
		
		$forum_origin = spip_query( "SELECT * FROM spip_forum WHERE id_forum='$option2'");
		while($data_orig = spip_fetch_array($forum_origin)) {
			$id_article=$data_orig['id_article'];
			$auteur = extraire_multi($data_orig['auteur']);
			$art= spip_query( "SELECT * FROM spip_articles WHERE id_article='$id_article'");
			while($date_art= spip_fetch_array($art)) {
			$titre=$date_art['titre'];
			}
			
			
			if ($type=='question_forum_auteur_article'){
				$url  = generer_url_public("article","id_article=$id_article&forum_off=voir#forum$option2",'false');
				$sujet = "[" .$nom_site_spip . "]"._T('encheres:question_objet', array('titre' => typo($data_orig['titre'])));

				$parauteur = (strlen($auteur) <= 2) ? '' :	  (" " ._T('forum_par_auteur', array('auteur' => $auteur)) .  ($data_orig['email_auteur'] ? ' <' . $data_orig['email_auteur'] . '>' : ''));
		
				$message =_T('encheres:pas_repondre')."\n\n"
				._T('bonjour')."\n\n"
				._T('encheres:email_question_objet',array('texte' => textebrut(propre($data_orig['texte'])),'nom_question' => $auteur,'titre' => typo($data_orig['titre']),'url' => $url))."\n\n"
				._T('encheres:email_signature')."\n\n"._T('message_auto');
				}
			else {
				$id_auteur = sql_getfetsel("id_auteur", "spip_auteurs_articles", "id_article = $id_article");		
				$nom_asso = sql_getfetsel("nom", "spip_auteurs", "id_auteur = $id_auteur");							
				$forum_reponse = spip_query( "SELECT * FROM spip_forum WHERE id_forum='$option'");
				$url  = generer_url_public("article","id_article=$id_article",'false');	
								
				while($data_reponse = spip_fetch_array($forum_reponse))	{
		
		
				$sujet = "[" .$nom_site_spip . "]"._T('encheres:reponse_objet', array('titre' => typo($data_orig['titre'])));

				$parauteur = (strlen($auteur) <= 2) ? '' :	  (" " ._T('forum_par_auteur', array('auteur' => $auteur)) .  ($data_orig['email_auteur'] ? ' <' . $data_orig['email_auteur'] . '>' : ''));
		
				$message = _T('encheres:pas_repondre')."\n\n"
				._T('bonjour')."\n\n"
				._T('encheres:email_reponse_objet',array('question' => textebrut(propre($data_orig['texte'])),'reponse' => textebrut(propre($data_reponse['texte'])),'nom_reponse' => extraire_multi($nom_asso),'titre' => typo($data_orig['titre']),'url' => $url))."\n\n"
				._T('encheres:email_signature')."\n\n"._T('message_auto');
				}
				}
			}
		}

			//Notification d'un mesage posté sur une rubrique

	elseif ($type=='reponse_forum_rubrique' OR $type=='question_forum_auteur_rubrique') {
		if ($langue) lang_select($langue);
		
		$forum = spip_query( "SELECT * FROM spip_forum WHERE id_forum='$option2'");
		while($data_orig = spip_fetch_array($forum)) {
			$auteur = extraire_multi($data_orig['auteur']);
			$id_rubrique=$data_orig['id_rubrique'];
			$question=$data_orig['texte'];			
			}
			$art= spip_query( "SELECT * FROM spip_rubriques WHERE id_rubrique='$id_rubrique'");
			while($date_art= spip_fetch_array($art)) {
			$titre=$date_art['titre'];
			$id_auteur=$date_art['id_auteur'];			
			$nom_asso= spip_query( "SELECT 'nom' FROM spip_auteurs WHERE id_auteur='$id_auteur'");

			}
			
						
			if ($type=='question_forum_auteur_rubrique'){
				$url  = generer_url_public("rubrique","id_rubrique=$id_rubrique&forum_off=voir#forum$option2",'false');
				$sujet = "[" .$nom_site_spip . "]"._T('encheres:question_projet', array('titre' => typo($data_orig['titre'])));

				$message =_T('encheres:pas_repondre')."\n\n"
				._T('bonjour')."\n\n"
				._T('encheres:email_question_projet',array('texte' => $question,'nom_question' => $auteur,'titre' => typo($data_orig['titre']),'url' => $url))."\n\n"
				._T('encheres:email_signature')."\n\n"._T('message_auto');
				}
			else {
				$url  = generer_url_public("article","id_article=$id_article",'false');
				$sujet = "[" .$nom_site_spip . "]"._T('encheres:reponse_projet', array('titre' => typo($data_orig['titre'])));						
				$forum_reponse = spip_query( "SELECT * FROM spip_forum WHERE id_forum='$option'");
				while($data_reponse = spip_fetch_array($forum_reponse))			
				$message = _T('encheres:pas_repondre')."\n\n"
				._T('bonjour')."\n\n"
				._T('encheres:email_reponse_projet',array('question' => textebrut(propre($data_orig['texte'])),'reponse' => textebrut(propre($data_reponse['texte'])),'nom_reponse' => extraire_multi($nom_asso),'titre' => typo($data_orig['titre']),'url' => $url))."\n\n"
				._T('encheres:email_signature')."\n\n"._T('message_auto');
				}

		};
			// Partie générale, envoi des mails

	if (envoyer_mail($email,$sujet,$message,$from,$header))

		return spip_log("Email visiteur $email\n$sujet\n$message\n",'encheres_emails');
	else
		return spip_log("Échec envoi email visiteur $email\n$sujet\n$message\n$type\n$header",'encheres_emails');
}
?>