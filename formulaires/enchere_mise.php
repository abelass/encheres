<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_enchere_mise_charger_dist($id_encheres_objet)
{
	$valeurs = array('id_encheres_objet'=>$id_encheres_objet,'montant'=>'','palier_encherissement'=>'','id_auteur'=>'');


	$data = sql_fetsel('*','spip_encheres_objets','id_encheres_objet='.$id_encheres_objet);

	$montant_precedent = $data['prix_actuel']>0 ?$data['prix_actuel']:$data['prix_depart'];
	$prix_achat_inmediat= $data['prix_achat_inmediat'];
	$valeurs['montant'] = $montant_precedent;

	$data = sql_fetsel('*','spip_encherisseurs','id_encheres_objet='.$id_encheres_objet.' AND suivre=""','','prix_maximum DESC');

	if(isset($valeurs['montant']))$valeurs['montant'] = $montant_precedent+1;
	$prix_max_min = $data['prix_maximum'];

	if ($prix_max_min<$montant_precedent){
		$prix_max_min = $montant_precedent+2;
			}
	else{
		$prix_max_min = $data['prix_maximum']+1;
		}
	$valeurs['prix_maximum_top'] = $prix_max_min;
    if($id_auteur=session_get('id_auteur'))$valeurs['_hidden'].='<input type="hidden" name="id_auteur" value="'.$id_auteur.'"/>';
$valeurs['_hidden'].='<input type="hidden" name="id_auteur" value="'.$id_auteur.'"/>';
	return $valeurs;
}



/* @annotation: Validation des champs obligatoires */
function formulaires_enchere_mise_verifier_dist($id_encheres_objet){
	include_spip('encheres_fonctions');	
    include_spip('inc/config');
    $config=lire_config('encheres');
	$devise = traduire_devise($config['devise']);
	$erreurs = array();
	/* @annotation: le champ prix_livraison est obligatoire si la marchandise est livré ou envoyé ou les deux, si pas de frais de livraison exigé, on permet la valeur 0*/

		$data = sql_fetsel('*','spip_encheres_objets','id_encheres_objet='.$id_encheres_objet);

		$montant_precedent = $data['montant'];
		$prix_achat_inmediat= isset($data['prix_achat_inmediat'])?$data['prix_achat_inmediat']:'';
		$statut= $data['statut'];				


	if(!isset($config['activer_palier_encherissment']) AND !_request('montant')) $erreurs['montant'] = _T('encheres:champ_obligatoire');

	

	if ($prix_achat_inmediat!='inmediat') {
	// Test si le montant peut être indiqué manuellement, si palier d'encherissment ne sont pas activés    
    if(_request('montant')){
		if($objet = sql_fetsel('*','spip_encheres_objets','id_encheres_objet='.$id_encheres_objet)){
			$montant_precedent = $objet['prix_actuel'];
			$valideur='ok';
			}
		if($valideur){
		      $data = sql_fetsel('*','spip_encheres_objets','id_encheres_objet='.$id_encheres_objet.' AND suivre=""','','prix_maximum DESC');

				$prix_max_min = $data['prix_maximum'];
				$prix_maximum_comparer = $data['prix_maximum'];
				$enchere='ok';
				if ($prix_max_min<$montant_precedent){
					$prix_max_min = $montant_precedent+2;
					}
				else{ 
					$prix_max_min = $data['prix_maximum']+1;
					}
				if (_request('montant') AND !ctype_digit(_request('montant')) ) {	
				$erreurs['montant'] = _T('encheres:prix_valide');
						}
				elseif(_request('montant') < $montant_precedent){
				$montant_min = $montant_precedent;		
				$erreurs['montant'] = _T('encheres:montant_trop_bas', array('montant_min' => $montant_min,'devise'=>$devise));
					}
				elseif(_request('montant') == $montant_precedent AND $enchere){
				$montant_min = $montant_precedent+1;			
				$erreurs['montant'] = _T('encheres:montant_trop_bas', array('montant_min' => $montant_min,'devise'=>$devise));
					}	
				elseif(_request('montant') == $prix_maximum_comparer AND !_request('prix_maximum')){
				$montant_min = $prix_maximum_comparer+1;
				$erreurs['montant'] = _T('encheres:montant_trop_bas', array('montant_min' => $montant_min,'devise'=>$devise));
					}					
				elseif(_request('montant') == $prix_maximum_comparer AND _request('prix_maximum') == $prix_maximum_comparer ){
				$montant_min = $prix_maximum_comparer+1;
				$erreurs['prix_maximum'] = _T('encheres:montant_trop_bas', array('montant_min' => $montant_min,'devise'=>$devise));
					}					
				elseif(_request('prix_maximum') AND _request('prix_maximum') == $prix_maximum_comparer){
				$montant_min = $prix_maximum_comparer+1;
				$erreurs['prix_maximum'] = _T('encheres:montant_trop_bas', array('montant_min' => $montant_min,'devise'=>$devise));
					}
				elseif(_request('prix_maximum') AND _request('prix_maximum') <= $montant_precedent){
				$montant_min = $montant_precedent+1;
				$erreurs['prix_maximum'] = _T('encheres:montant_trop_bas', array('montant_min' => $montant_min,'devise'=>$devise));
					}					

			}
		}
	else {
		if (_request('montant') AND !ctype_digit(_request('montant')) ) {
		$erreurs['montant'] = _T('encheres:prix_valide');
				}
		elseif(_request('montant') != $montant_precedent){
		$erreurs['montant'] = _T('encheres:montant_erreur');
			}
		};
    }        
	if (count($erreurs))
		$erreurs['message_erreur'] = _T('encheres:erreur_saisie');
	return $erreurs;
}

/* @annotation: Actualisation de la base de donnée */
function formulaires_enchere_mise_traiter_dist($id_encheres_objet){
        include_spip('inc/config');
        $config=lire_config('encheres');

		$id_auteur = _request('id_auteur');
		$montant = _request('montant');
		$palier_encherissement = _request('palier_encherissement');
		$date_creation = date('Y-m-d G:i:s');
		//$url_retour= generer_url_public("article","id_article=$id_article");
		//$url_retour= str_replace('&amp;','&',$url_retour); 
		//$url_var='&id_objet='.$id_objet;
		$date_actuel= time();

		//Établit les données de base

		$objet = sql_fetsel('*','spip_encheres_objets',array('id_encheres_objet='.$id_encheres_objet));

		$statut = $objet['statut'];
		$date_fin = $objet['date_fin'];
		$date_fin_jours = date('d-m-Y',strtotime($date_fin));
		$date_fin_heures = date('G:i:s',strtotime($date_fin));
		$montant_actuel =$objet['montant '];

		$split_jours = explode("-", $date_fin_jours);
		$split_heures = explode(":", $date_fin_heures);

		$date_fin = mktime($split_heures[0], $split_heures[1], $split_heures[2], $split_jours[1], $split_jours[0], $split_jours[2]) ;
		$date_difference = ($date_fin-$date_actuel)/(3600*24);
					
	
		$encherisseur = sql_fetsel('*','spip_encherisseurs',array('id_encheres_objet='.sql_quote($id_objet),'id_auteur='.sql_quote($id_auteur)));		
		$id_encherisseur = $encherisseur['id_encherisseur'];
		$suivre = $encherisseur['suivre'];


		//Établit les données du gagnant actuel
		$encherisseur_gagnant = spip_query( "SELECT * FROM spip_encheres_encherisseurs WHERE id_objet='$id_objet' ORDER BY prix_maximum DESC LIMIT 1");
				while($data = sql_fetch($encherisseur_gagnant)) {
					$prix_max_actuel = $data['prix_maximum'];
					$id_encherisseur_top	= $data['id_encherisseur'];

						//Établit l'id du gagnant à cause d'un prix maximum
					if ($montant_actuel<$prix_max_actuel AND $montant<=$prix_max_actuel AND $prix_maximum<$prix_max_actuel){
						$id_encherisseur_top_gagnant = $id_encherisseur_top;
						}
					}
					

		/* actions seulement possible si le statut est le bon*/
		if ($statut=='mise_en_vente' OR $statut=='mise_en_vente_active' AND $date_fin > $date_actuel){

			/* @annotation: Si l'id_client  n'existe pas encore on crée un nouveau*/
			if (!$id_encherisseur){
				$arg_inser_client = array(
					'id_auteur' => $id_auteur,
					'id_encheres_objet' => $id_encheres_objet,
					'date_creation' => $date_creation,
					'prix_maximum' => $prix_maximum,
					);
				$id_encherisseur = sql_insertq('spip_encherisseurs',$arg_inser_client);
				}
			elseif($prix_maximum)
			    sql_updateq('spip_encheres_encherisseurs',array('prix_maximum' => $prix_maximum, 'suivre' => ''),'id_encherisseur='.$id_encherisseur);
			elseif($suivre=='1'){
				spip_query ("UPDATE spip_encheres_encherisseurs SET suivre = '' WHERE id_objet='$id_objet'");
				
				// Invalider les caches
				include_spip('inc/invalideur');
				suivre_invalideur("id='id_objet/$id_objet'");
					}
			if ($prix_achat_inmediat!='inmediat'){
					$statut='mise_en_vente_active';
					
					$acheteur =sql_fetsel('*','spip_auteurs LEFT JOIN spip_auteurs_elargis USING(id_auteur)',array('id_auteur='.sql_quote($id_encherisseur)));
	
					if($acheteur){
							$email = $acheteur['email'];
							// Invalider les caches
							include_spip('inc/invalideur');
							suivre_invalideur("id='id_objet/$id_objet'");		
							}
	
					//L'envoi des mails, avant de la actualisation de la BDD afin de permettre la détermination de l'encherisseur surpassé
					
					// les infos projets	
						
					$artobjet=sql_fetsel('*','spip_articles',array('id_article='.sql_quote($id_article)));
					
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
	
					//Mail de confirmation pour l'encherisseur surpassé sauf celui qui reste gagnant à cause d'un prix maximum supérieur
	
					$sql = spip_query( "SELECT * FROM spip_encheres_mises WHERE id_objet='$id_objet' ORDER BY montant DESC LIMIT 1");
						while($data = sql_fetch($sql)) {
							$id_encherisseur_surpasse=$data['id_encherisseur'];
							if($id_encherisseur_surpasse != $id_encherisseur){
								$encherisseur_surpasse = requete_auteurs_elargis(array('id_auteur='.sql_quote($id_encherisseur_surpasse),' id_auteur!='.sql_quote($id_encherisseur_top_gagnant)));
								
								$contexte['acheteur']=$encherisseur_surpasse;
	
								$envoyer_message_visiteur = charger_fonction('envoyer_message_acheteur','inc');
								$envoyer_message_visiteur($encherisseur_surpasse['email'],'enchere_surpassee',$id_objet,$contexte);
	
								}
							}
	
	
	
					//Mail de confirmation pour l'encherisseur
					if(($montant>$prix_max_actuel AND $prix_maximum>$prix_max_actuel) OR ($montant>$prix_max_actuel AND !$prix_max) OR ($prix_maximum>$prix_max_actuel AND $id_encherisseur_top!=$id_encherisseur)){
					
					$contexte['acheteur']=$acheteur;		
					
					$envoyer_message_acheteur = charger_fonction('envoyer_message_acheteur','inc');
					$envoyer_message_acheteur($email,'enchere_reussie',$id_objet,$contexte);
						};
						
						
					//Mail de confirmation pour le kidonateur	
					
					$contexte['kidonateur']='';																				
					
					$envoyer_message_kidonateur = charger_fonction('envoyer_message_kidonateur','inc');
					$envoyer_message_kidonateur('','enchere_effectue',$id_objet,$contexte);
						
						
					//Mail de confirmation pour le webmaster
	
					$envoyer_message_webmestre = charger_fonction('envoyer_message_webmestre','inc');
					$envoyer_message_webmestre('mise',$id_objet,$id_encherisseur);
	
					//Actualisation de la BDD
	
					//En cas de présence d'un prix maximum préexistant et d'un nouveau le surpassant, le prix est superieur d'un euro à l'ancien prix maximum
	
						if ($prix_maximum>$prix_max_actuel AND $prix_max_actuel>$montant_actuel)	{
							if ($id_encherisseur!=$id_encherisseur_top){
								$montant=$prix_max_actuel+1;
								}
							else{$montant=$montant_actuel;
								};
							}
	
					//En cas de présence d'un prix maximum préexistant et d'un nouveau prix maximum inférieur le montant est le prix_maximuum plus 1
	
						elseif ($prix_maximum>$montant_actuel AND $prix_max_actuel>$montant AND $prix_maximum<$prix_max_actuel)	{
								$arg_inser_mise = array(
								'id_mise' => '',
								'id_encherisseur' => $id_encherisseur,
								'id_objet' => $id_objet,
								'montant' => $montant,
								'date_mise' => $date_creation
								);
								$id_mise = sql_insertq('spip_encheres_mises',$arg_inser_mise);
								
								$montant=$prix_maximum+1;
								$id_encherisseur = $id_encherisseur_top_gagnant;
								
	
							//Envoi de mail à l'encherisseur qui vient d'être surpassé
	// 						$envoyer_message_visiteur = charger_fonction('envoyer_message_visiteur','inc');
	// 						$envoyer_message_visiteur($email,'enchere_surpassee',$id_objet);
	// 						$id_encherisseur=$id_encherisseur_top;
							}
	
					//En cas de présence d'un prix maximum préexistant et supérieur à la mise et d'unu nouvelle mise d'un encherisseur qui n'est pas celui du prix maximum gagnant, en enregistre la mise qui sera surpassé par la suite par l'encherisseur du prix maximim gagnant.
	
						elseif ($prix_max_actuel>=$montant AND !$prix_maximum AND $id_encherisseur!==$id_encherisseur_top)	{
							if ($prix_max_actue!=$montant){ echo '2';
								$arg_inser_mise = array(
								'id_mise' => '',
								'id_encherisseur' => $id_encherisseur,
								'id_objet' => $id_objet,
								'montant' => $montant,
								'date_mise' => $date_creation
								);
								$id_mise = sql_insertq('spip_encheres_mises',$arg_inser_mise);
								}
	
							//Envoi de mail à l'encherisseur qui vient d'être surpassé
	//  						$envoyer_message_visiteur = charger_fonction('envoyer_message_visiteur','inc');
	//  						$envoyer_message_visiteur($email,'enchere_surpassee',$id_objet);
	
							//Enregistrement de l'encherisseur gagnant (celui du prix maximun gagnant) en ajoutant 1 Euro au montant original
							$id_encherisseur=$id_encherisseur_top;
							if($prix_max_actuel!=$montant){
								$montant=$montant+1;
								}
							}
	
					spip_query("UPDATE spip_encheres_objets SET montant='$montant',statut='$statut'  WHERE id_objet='$id_objet'");
	
					$arg_inser_mise = array(
					'id_mise' => '',
					'id_encherisseur' => $id_encherisseur,
					'id_objet' => $id_objet,
					'montant' => $montant,
					'date_mise' => $date_creation
					);
					$id_mise = sql_insertq('spip_encheres_mises',$arg_inser_mise);

				}
			else {
					$actualiser = charger_fonction('actions_enchere_gagne','inc');
					$actualiser('cloture_mise_inmediat',$id_objet,$id_encherisseur,$contexte);
				};
			}
		else{$url_var='&id_objet='.$id_objet.'&enchere=termine';}
		
		// Invalider les caches
		include_spip('inc/invalideur');
		suivre_invalideur("id='id_objet/$id_objet'");	

		// construction de la page de retour
		header ('location:'.$url_retour.$url_var);
	}

?>