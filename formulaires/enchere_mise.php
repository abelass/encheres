<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_enchere_mise_charger_dist($id_encheres_objet){
    $date_actuel=date('Y-m-d H:i:s');
	$valeurs = array('id_encheres_objet'=>$id_encheres_objet,'montant'=>'','palier_encherissement'=>'','id_auteur'=>'','multiplicateur');


	$objet = sql_fetsel('*','spip_encheres_objets','id_encheres_objet='.$id_encheres_objet);
    
    $valeurs['editable']=true;

	$montant_precedent = $objet['prix_actuel']>0 ?$$objet['prix_actuel']:$objet['prix_depart'];
	$prix_achat_inmediat= $$objet['prix_achat_inmediat'];
	$valeurs['montant'] = $montant_precedent;
    $statut=$objet['statut'];

	$encherisseur = sql_fetsel('*','spip_encherisseurs','id_encheres_objet='.$id_encheres_objet.' AND suivre=""','','prix_maximum DESC');
    
    
    //Cloturer les evenement 'a termes pas encore traité
    if($objet['date_fin'] <= $date_actuel){
        if(in_array($statut,array('publie','mise_en_vente_active'))){
                    $actualiser = charger_fonction('actions_enchere_gagne','inc');
                    $actualiser('cloture_cron_'.$statut,$id_encheres_objet);
                }

        $valeurs['editable']=false;
    }

	if(isset($valeurs['montant']))$valeurs['montant'] = $montant_precedent+1;
	$prix_max_min = $data['prix_maximum'];

	if ($prix_max_min<$montant_precedent){
		$prix_max_min = $montant_precedent+2;
			}
	else{
		$prix_max_min = $data['prix_maximum']+1;
		}
	$valeurs['prix_maximum_top'] = $prix_max_min;
    include_spip('inc/session');
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
        $actualiser = charger_fonction('actions_enchere_gagne','inc');
    
        include_spip('inc/config');
        $config=lire_config('encheres');
		$prix_maximum = _request('prix_maximum');
		$id_auteur = _request('id_auteur');
		$montant = _request('montant');
		$palier_encherissement = _request('palier_encherissement');
		$date_creation = date('Y-m-d G:i:s');
		$date_actuel= time();
        $multiplicateur=_request('multiplicateur')?_request('multiplicateur'):1;

		//Établit les données de base

		$objet = sql_fetsel('*','spip_encheres_objets','id_encheres_objet='.$id_encheres_objet);

		$statut = $objet['statut'];
		$date_fin = $objet['date_fin'];
		$date_fin_jours = date('d-m-Y',strtotime($date_fin));
		$date_fin_heures = date('G:i:s',strtotime($date_fin));
		$montant_actuel =$objet['prix_actuel'];

		$split_jours = explode("-", $date_fin_jours);
		$split_heures = explode(":", $date_fin_heures);

		$date_fin = mktime($split_heures[0], $split_heures[1], $split_heures[2], $split_jours[1], $split_jours[0], $split_jours[2]) ;
		$date_difference = ($date_fin-$date_actuel)/(3600*24);
					
	
		$encherisseur = sql_fetsel('*','spip_encherisseurs',array('id_encheres_objet='.sql_quote($id_encheres_objet),'id_auteur='.sql_quote($id_auteur)));		
		$id_encherisseur = $encherisseur['id_encherisseur'];
		$suivre = $encherisseur['suivre'];

		//Établit les données du gagnant actuel
		$encherisseur_gagnant = sql_select('*','spip_encherisseurs','id_encheres_objet='.$id_encheres_objet.' AND gagnant=1');


		$prix_max_actuel = $encherisseur_gagnant['prix_maximum'];
		$id_encherisseur_top	= $encherisseur_gagnant['id_encherisseur'];
        
        if($montant){
            //Établit l'id du gagnant à cause d'un prix maximum
    		if ($montant_actuel<$prix_max_actuel AND $montant<=$prix_max_actuel AND $prix_maximum<$prix_max_actuel){
    			$id_encherisseur_top_gagnant = $id_encherisseur_top;
    			}
            }


		/* actions seulement possible si le statut est le bon*/
		if (($statut=='publie' OR $statut=='mise_en_vente_active') AND $date_fin > $date_actuel){

			/* @annotation: Si l'id_encherisseur  n'existe pas encore on crée un nouveau*/
			if (!$id_encherisseur){
				$arg_inser_client = array(
					'id_auteur' => $id_auteur,
					'id_encheres_objet' => $id_encheres_objet,
					'date_creation' => $date_creation,
					'prix_maximum' => $prix_maximum,
					);
				$id_encherisseur = sql_insertq('spip_encherisseurs',$arg_inser_client);
				}
			/*elseif($prix_maximum)
			    sql_updateq('spip_encherisseurs',array('prix_maximum' => $prix_maximum, 'suivre' => ''),'id_encherisseur='.$id_encherisseur);
			elseif($suivre=='1'){
				spip_query ("UPDATE spip_encherisseurs SET suivre = '' WHERE id_encheres_objet='$id_encheres_objet'");*/
				
				// Invalider les caches
				include_spip('inc/invalideur');
				suivre_invalideur("id='id_encheres_objet/$id_encheres_objet'");
					
			if ($prix_achat_inmediat!='inmediat'){
					$statut='mise_en_vente_active';
					
					$acheteur =sql_fetsel('*','spip_auteurs',array('id_auteur='.sql_quote($id_auteur)));
	
					if($acheteur){
							$email = $acheteur['email'];
							}

            	//Actualisation de la BDD
            
                // si par palier
                if($palier_encherissement){
                    $montant=$montant_actuel+($multiplicateur*$palier_encherissement);
                     $arg_inser_mise = array(
                            'id_encherisseur' => $id_encherisseur,
                            'id_encheres_objet' => $id_encheres_objet,
                            'montant' => $montant,
                            'date' => $date_creation
                            );
                     sql_insertq('spip_mises',$arg_inser_mise);
                     sql_updateq('spip_encherisseurs',array('gagnant'=>1),'id_encherisseur='.$id_encherisseur);
                     sql_updateq('spip_encherisseurs',array('gagnant'=>''),'id_encheres_objet='.$id_encheres_objet.' AND id_encherisseur!='.$id_encherisseur);                     
                     sql_updateq('spip_encheres_objets',array('prix_actuel'=>$montant,'statut'=>$statut),'id_encheres_objet='.$id_encheres_objet);
                    
                }
                //En cas de présence d'un prix maximum préexistant et d'un nouveau le surpassant, le prix est superieur d'un euro à l'ancien prix maximum
                else{
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
            				'id_encheres_objet' => $id_encheres_objet,
            				'montant' => $montant,
            				'date' => $date_creation
            				);
            				$id_mise = sql_insertq('spip_mises',$arg_inser_mise);
            				
            				$montant=$prix_maximum+1;
            				$id_encherisseur = $id_encherisseur_top_gagnant;
            				
            
            			//Envoi de mail à l'encherisseur qui vient d'être surpassé
            // 						$envoyer_message_visiteur = charger_fonction('envoyer_message_visiteur','inc');
            // 						$envoyer_message_visiteur($email,'enchere_surpassee',$id_encheres_objet);
            // 						$id_encherisseur=$id_encherisseur_top;
            			}
            
            					//En cas de présence d'un prix maximum préexistant et supérieur à la mise et d'unu nouvelle mise d'un encherisseur qui n'est pas celui du prix maximum gagnant, en enregistre la mise qui sera surpassé par la suite par l'encherisseur du prix maximim gagnant.
            	
            		elseif ($prix_max_actuel>=$montant AND !$prix_maximum AND $id_encherisseur!==$id_encherisseur_top)	{
            			if ($prix_max_actue!=$montant){
            				$arg_inser_mise = array(
            				'id_mise' => '',
            				'id_encherisseur' => $id_encherisseur,
            				'id_encheres_objet' => $id_encheres_objet,
            				'montant' => $montant,
            				'date' => $date_creation
            				);
            				$id_mise = sql_insertq('spip_mises',$arg_inser_mise);
            				}
            							//Envoi de mail à l'encherisseur qui vient d'être surpassé
            	//  						$envoyer_message_visiteur = charger_fonction('envoyer_message_visiteur','inc');
            	//  						$envoyer_message_visiteur($email,'enchere_surpassee',$id_encheres_objet);
            	
            							//Enregistrement de l'encherisseur gagnant (celui du prix maximun gagnant) en ajoutant 1 Euro au montant original
            							$id_encherisseur=$id_encherisseur_top;
            							if($prix_max_actuel!=$montant){
            								$montant=$montant+1;
            								}
            							}
            	
            					spip_query("UPDATE spip_encheres_objets SET montant='$montant',statut='$statut'  WHERE id_encheres_objet='$id_encheres_objet'");
            	
            					$arg_inser_mise = array(
            					'id_mise' => '',
            					'id_encherisseur' => $id_encherisseur,
            					'id_encheres_objet' => $id_encheres_objet,
            					'montant' => $montant,
            					'date' => $date_creation
            					);
            					$id_mise = sql_insertq('spip_mises',$arg_inser_mise);
            	   }
				}
			else {
					$actualiser('cloture_mise_inmediat',$id_encheres_objet,$id_encherisseur,$contexte);
				};
		  }
    elseif(($statut=='publie' OR $statut=='mise_en_vente_active') AND $date_fin <= $date_actuel)   {
        $actualiser('cloture_cron_'.$statut,$id_encheres_objet);
    }
          		// Invalider les caches
		include_spip('inc/invalideur');
		suivre_invalideur("id='id_encheres_objet/$id_encheres_objet'");	

	}

?>