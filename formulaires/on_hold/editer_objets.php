<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

/* @annotation: Charge les valeurs par défaut pour le fomulaire editer objet */

function formulaires_editer_objets_charger_dist($option='',$id_article=''){
	$valeurs = array('id_rubrique'=>'','id_article'=>'','id_auteur'=>'','id_objet'=>'','id_objet_source'=>'','prix_depart'=>'','compte_bancaire'=>'','iban'=>'','prix_achat_inmediat'=>'','mode_livraison'=>'','livraison_etranger'=>'','prix_livraison'=>'','prix_livraison_etranger'=>'','nombre'=>'','duree'=>'','date_debut'=>'','statut'=>'','type'=>'','exec'=>'','edition'=>'','url_retour'=>'','option'=>$option,'menu'=>'','jour_debut_ev'=>'','mois_debut_ev'=>'','annee_debut_ev'=>'','jour_fin_ev'=>'','mois_fin_ev'=>'','annee_fin_ev'=>'','date_debut_evenement'=>'','date_fin_evenement'=>'','courrier_velo'=>'','remise_vente_automatique'=>'','joursactifs'=>'','jours_actifs'=>'','mode'=>'','commentaire'=>'');
	$valeurs['id_objet'] =_request('id_objet');
	$valeurs['id_article'] =_request('id_article');
	$valeurs['mode'] =_request('mode');	
	$valeurs['exec'] = _request('exec');
	$valeurs['voir'] = _request('voir');
	$id_article=$valeurs['id_article'];
	$valeurs['statut']= "stand_by";
	$valeurs['statut']= _request('statut');
	$valeurs['id_auteur']= _request('id_auteur');
	$valeurs['edition'] =_request('edition');
	$valeurs['menu'] =_request('menu');
	$valeurs['courrier_velo'] =_request('courrier_velo');
	$valeurs['jour'] =_request('jour');
	$valeurs['mois'] =_request('mois');
	$valeurs['annee'] =_request('annee');
	$valeurs['jour_debut_ev'] =_request('jour_debut_ev');
	$valeurs['mois_debut_ev'] =_request('mois_debut_ev');
	$valeurs['annee_debut_ev'] =_request('annee_debut_ev');	
	$valeurs['jour_fin_ev'] =_request('jour_fin_ev');
	$valeurs['mois_fin_ev'] =_request('mois_fin_ev');
	$valeurs['annee_fin_ev'] =_request('annee_fin_ev');
	$valeurs['joursactifs'] =_request('joursactifs');
	$valeurs['commentaire'] =_request('commentaire');	
	$valeurs['date_debut_evenement'] = $valeurs['annee_debut_ev'].'-'.$valeurs['mois_debut_ev'].'-'.$valeurs['jour_debut_ev'];		
	$valeurs['date_fin_evenement'] = $valeurs['annee_fin_ev'].'-'.$valeurs['mois_fin_ev'].'-'.$valeurs['jour_fin_ev']; ;		
		
	
	
	$valeurs['remise_vente_automatique'] =_request('remise_vente_automatique');

 	$sql = spip_query( "SELECT * FROM spip_auteurs_articles WHERE id_article='$id_article' ");
 				while($data = spip_fetch_array($sql)) {
				$valeurs['id_auteur']=$data['id_auteur'];
				$valeurs['commentaire']=$data['commentaire'];				
							}

	$sql = spip_query( "SELECT * FROM spip_articles WHERE id_article='$id_article' AND id_trad != '0'");
				while($data = spip_fetch_array($sql)) {
				$id_trad=$data['id_trad'];
				$valeurs['id_rubrique']=$data['id_rubrique'];
				$valeurs['commentaire']=$data['commentaire'];					

				$sql = spip_query( "SELECT * FROM spip_auteurs_articles WHERE id_article='$id_trad' ");
					while($data = spip_fetch_array($sql)) {
					$id_article=$data['id_article'];
					}
				}

		/* @annotation: Modification: Si pas de id_object dans le context, charge les info de l'objet  avec l'id_source=0, cad l'entrée principale*/

		if (!_request('id_objet')){
			$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_article='$id_article' AND id_objet_source='0' ");
				while($data = spip_fetch_array($sql)) {
				$valeurs['id_objet']=$data['id_objet'];
				$valeurs['id_objet_source']=$data['id_objet_source'];
				$valeurs['prix_depart']=$data['prix_depart'];
				$valeurs['prix_achat_inmediat']=$data['prix_achat_inmediat'];
				$date_debut=$data['date_debut'];
				$valeurs['mode_livraison']=$data['mode_livraison'];
				$valeurs['livraison_etranger']=$data['livraison_etranger'];				
				$valeurs['prix_livraison']=$data['prix_livraison'];
				$valeurs['prix_livraison_etranger']=$data['prix_livraison_etranger'];				
				$valeurs['nombre']=$data['nombre'];
				$valeurs['duree']=$data['duree'];
				$valeurs['statut']=$data['statut'];
				$valeurs['type']=$data['type'];
				$valeurs['date_debut_programmee']=$data['date_debut'];
				$valeurs['courrier_velo']=$data['courrier_velo'];
				$valeurs['remise_vente_automatique']=$data['remise_vente_automatique'];				
				$valeurs['date_debut_evenement']=$data['date_debut_evenement'];
				$valeurs['date_fin_evenement']=$data['date_fin_evenement'];
				$valeurs['joursactifs']= $data['jours_actifs'];								
							
				if ($date_debut!='0000-00-00 00:00:00'){
				$date_debut = date('d-m-Y',strtotime($data['date_debut']));
  				$date_debut_explode = explode("-", $date_debut);
				$valeurs['jour'] = $date_debut_explode[0];
				$valeurs['mois'] = $date_debut_explode[1];
				$valeurs['annee'] = $date_debut_explode[2];
					}
				else {
				$valeurs['jour'] = '00';
				$valeurs['mois'] = '00';
				$valeurs['annee'] = '0000';
					}
				if ($date_debut_evenement !='0000-00-00 00:00:00'){
				$date_debut_evenement = date('d-m-Y',strtotime($data['date_debut_evenement']));
  				$date_debut_evenement_explode = explode("-",$date_debut_evenement);
				$valeurs['jour_debut_ev'] = $date_debut_evenement_explode[0];
				$valeurs['mois_debut_ev'] = $date_debut_evenement_explode[1];
				$valeurs['annee_debut_ev'] = $date_debut_evenement_explode[2];
					}
				else {
				$valeurs['jour_debut_ev'] = '00';
				$valeurs['mois_debut_ev'] = '00';
				$valeurs['annee_debut_ev'] = '0000';
					}
				if ($date_fin_evenement !='0000-00-00 00:00:00'){
				$date_fin_evenement = date('d-m-Y',strtotime($data['date_fin_evenement']));
  				$date_fin_evenement_explode = explode("-",$date_fin_evenement);
				$valeurs['jour_fin_ev'] = $date_fin_evenement_explode[0];
				$valeurs['mois_fin_ev'] = $date_fin_evenement_explode[1];
				$valeurs['annee_fin_ev'] = $date_fin_evenement_explode[2];
					}
				else {
				$valeurs['jour_fin_ev'] = '00';
				$valeurs['mois_fin_ev'] = '00';
				$valeurs['annee_fin_ev'] = '0000';
					}		
					
				}
			}
		/* @annotation: Charge les infos de l'id du context*/
		else{
			$valeurs['id_objet'] = _request('id_objet');
			$id_objet=$valeurs['id_objet'];
 			$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet' ");
				while($data = spip_fetch_array($sql)) {
				$valeurs['id_objet']=$data['id_objet'];
				$valeurs['prix_depart']=$data['prix_depart'];
				$valeurs['id_objet_source']=$data['id_objet_source'];
 				$valeurs['prix_achat_inmediat']=$data['prix_achat_inmediat'];
 				$valeurs['mode_livraison']=$data['mode_livraison'];
 				$valeurs['livraison_etranger']=$data['livraison_etranger'];	
 				$valeurs['prix_livraison']=$data['prix_livraison'];
				$valeurs['prix_livraison_etranger']=$data['prix_livraison_etranger'];				
				$valeurs['nombre']=$data['nombre'];
				$valeurs['date_creation']=$data['date_creation'];
				$valeurs['duree']=$data['duree'];
				$date_debut=$data['date_debut'];
 				$valeurs['statut']=$data['statut'];
 				$valeurs['type']=$data['type'];				
				$valeurs['date_debut_programmee']=$data['date_debut'];
				$valeurs['courrier_velo']=$data['courrier_velo'];
				$valeurs['remise_vente_automatique']=$data['remise_vente_automatique'];	
				$valeurs['date_debut_evenement']=$data['date_debut_evenement'];
				$valeurs['date_fin_evenement']=$data['date_fin_evenement'];
				$valeurs['joursactifs']= $data['jours_actifs'];					
				
				if ($date_debut!='0000-00-00 00:00:00'){
				$date_debut = date('d-m-Y',strtotime($data['date_debut']));
					if($option=='remise_en_vente') $date_debut = date('d-m-Y');
  				$date_debut_explode = explode("-", $date_debut);
				$valeurs['jour'] = $date_debut_explode[0];
				$valeurs['mois'] = $date_debut_explode[1];
				$valeurs['annee'] = $date_debut_explode[2];
					}
				else {
				$valeurs['jour'] = '00';
				$valeurs['mois'] = '00';
				$valeurs['annee'] = '0000';
					};
				if ($date_debut_evenement !='0000-00-00 00:00:00'){
				$date_debut_evenement = date('d-m-Y',strtotime($data['date_debut_evenement']));
  				$date_debut_evenement_explode = explode("-",$date_debut_evenement);
				$valeurs['jour_debut_ev'] = $date_debut_evenement_explode[0];
				$valeurs['mois_debut_ev'] = $date_debut_evenement_explode[1];
				$valeurs['annee_debut_ev'] = $date_debut_evenement_explode[2];
					}
				else {
				$valeurs['jour_debut_ev'] = '00';
				$valeurs['mois_debut_ev'] = '00';
				$valeurs['annee_debut_ev'] = '0000';
					};
				if ($date_fin_evenement !='0000-00-00 00:00:00'){
				$date_fin_evenement = date('d-m-Y',strtotime($data['date_fin_evenement']));
  				$date_fin_evenement_explode = explode("-",$date_fin_evenement);
				$valeurs['jour_fin_ev'] = $date_fin_evenement_explode[0];
				$valeurs['mois_fin_ev'] = $date_fin_evenement_explode[1];
				$valeurs['annee_fin_ev'] = $date_fin_evenement_explode[2];
					}
				else {
				$valeurs['jour_fin_ev'] = '00';
				$valeurs['mois_fin_ev'] = '00';
				$valeurs['annee_fin_ev'] = '0000';
					}			
 			}
 		};
 		

	return $valeurs;
};

/* @annotation: Validation des champs obligatoires */
function formulaires_editer_objets_verifier_dist(){
	include_spip('encheres_fonctions');
	$devise = traduire_devise(lire_config('encheres/devise'));

	$jour =_request('jour');
	$mois =_request('mois');
	$annee =_request('annee');
	$jour_debut_ev =_request('jour_debut_ev');
	$mois_debut_ev =_request('mois_debut_ev');
	$annee_debut_ev =_request('annee_debut_ev');	
	$jour_fin_ev =_request('jour_fin_ev');
	$mois_fin_ev =_request('mois_fin_ev');
	$annee_fin_ev =_request('annee_fin_ev');	
	$date_debut = date(mktime(07, 00, 00 , _request('mois'), _request('jour'), _request('annee'))) ;
	$date_debut_evenement = $annee_debut_ev.'-'.$mois_debut_ev.'-'.$jour_debut_ev;
	$date_fin_evenement = $annee_fin_ev.'-'.$mois_fin_ev.'-'.$jour_fin_ev;		
	$date_creation = date('Y-m-d');
	$calculer = _request('calculer');
	$mode = _request('mode');	
	$joursactifs = _request('joursactifs');
	$url_retour=_request('url_retour');
	
	
	if (!_request('jour') OR _request('jour') == 00)	{
		$date_debut = '0000-00-00 00:00:00' ;
		if($mode=='billetterie'){
			$date_debut = $date_creation;
				}
			}
		else {
		$date_debut = date('Y-m-d G:i:s',mktime(07,00,00,$mois,$jour,$annee)) ;
		};



	$date_debut_jours = date('d-m-Y',strtotime($date_debut));
 	$date_fin_jours = date('d-m-Y',strtotime($date_fin_evenement));

	
	$split_jours_debut = explode("-", $date_debut_jours);
	$split_jours_fin = explode("-", $date_fin_jours);
	

	if ($mode=='billetterie'){
   		$date_debut = mktime(00, 00, 00, $split_jours_debut[1], $split_jours_debut[0], $split_jours_debut[2]) ;   
   				
   		$date_fin = mktime(00, 00, 00, $split_jours_fin[1], $split_jours_fin[0], $split_jours_fin[2]) ;
   	
		$difference_min=($date_fin-$date_debut)/86400;
		}
					
	if(!$calculer){
		
	
	$erreurs = array();
		

	/* @annotation: le champ prix_livraison est obligatoire si la marchandise est livré ou envoyé ou les deux, si pas de frais de livraison exigé, on permet la valeur 0*/


	if (!_request('option') OR _request('option')== 'modifier_objet'){
		if(_request('mode_livraison')!='venir' AND (_request('prix_livraison') != '0') ){
		// Si uniquement livraison dans le pays le prix livraison n'est pas obligatoire et le bic
		
			if ($mode=='billetterie'){
				// verifier que les champs obligatoires sont bien la :
				foreach(array('id_article','prix_depart','mode_livraison','nombre','joursactifs') as $obligatoire)
					if (!_request($obligatoire)) $erreurs[$obligatoire] = _T('encheres:champ_obligatoire');			
				}
			elseif (!_request ('livraison_etranger') ){
				// verifier que les champs obligatoires sont bien la :
				foreach(array('id_article','prix_depart','mode_livraison','prix_livraison','nombre','duree','type','compte_bancaire') as $obligatoire)
					if (!_request($obligatoire)) $erreurs[$obligatoire] = _T('encheres:champ_obligatoire');
				}			
			elseif (_request('prix_livraison_etranger') AND _request('prix_livraison') != '0') {
				// verifier que les champs obligatoires sont bien la :
				foreach(array('id_article','prix_depart','mode_livraison','prix_livraison','prix_livraison_etranger','nombre','duree','type','bic','iban', 'compte_bancaire') as $obligatoire)
					if (!_request($obligatoire)) $erreurs[$obligatoire] = _T('encheres:champ_obligatoire');
				}
			}
		// Si uniquement livraison dans le pàys le prix livraison n'est pas obligatoire et le bic	
		elseif (_request ('livraison_etranger') AND _request('mode_livraison')!='venir' AND _request('prix_livraison_etranger') != '0' ){
				// verifier que les champs obligatoires sont bien la :
				foreach(array('id_article','prix_depart','mode_livraison','prix_livraison','prix_livraison_etranger','nombre','duree','type','iban','bic', 'compte_bancaire') as $obligatoire)
					if (!_request($obligatoire)) $erreurs[$obligatoire] = _T('encheres:champ_obligatoire');	
			}
		
		/* @annotation: le champ prix_livraison n'est pas obligatoire si la marchandise sera cherché chez le vendeur*/
		else{
		// verifier que les champs obligatoires sont bien la :
		foreach(array('id_article','prix_depart','mode_livraison','nombre','duree','type') as $obligatoire)
			if (!_request($obligatoire)) $erreurs[$obligatoire] = _T('encheres:champ_obligatoire');
			};
		}
	elseif ($option=='remise_en_vente') {
		foreach(array('id_rubrique','prix_depart') as $obligatoire)
		if (!_request($obligatoire)) $erreurs[$obligatoire] = _T('encheres:champ_obligatoire');
		};

	if (_request('prix_depart') AND !ctype_digit(_request('prix_depart')) ){
		$erreurs['prix_depart'] = _T('encheres:prix_valide');
				}
		elseif(_request('prix_depart')<'5'){
		$erreurs['prix_depart'] = _T('encheres:prix_trop_bas',array('devise'=>$devise));
		}

	if (_request('nombre') AND !ctype_digit(_request('nombre'))){
		$erreurs['nombre'] = _T('encheres:nombre_valide');
				}

	if (_request('duree') AND !ctype_digit(_request('duree'))){
		$erreurs['duree'] = _T('encheres:duree_valide');
				}
	if (_request('prix_livraison') AND !ctype_digit(_request('prix_livraison'))){
		$erreurs['prix_livraison'] = _T('encheres:prix_valide');	
				}
				
	if (_request('prix_livraison_etranger') AND !ctype_digit(_request('prix_livraison_etranger'))){
		$erreurs['prix_livraison_etranger'] = _T('encheres:prix_valide');	
				}
	if ($mode=='billetterie'){			
		if ($date_debut_evenement AND $date_fin_evenement AND $difference_min<=12){
			$erreurs['jours_actifs'] = _T('encheres:erreur_date_fin_evenement');
			}
		}	
												
			

 	if (_request('date_debut') AND ! ereg('^([0-9]{4})-([0-9]{2})-([0-9]{2})$', _request('date_debut_programmee'), $regs)){		
 		$erreurs['date_debut_programmee'] = _T('encheres:date_valide');
 			}
   elseif (_request('date_debut') AND _request('date_debut_programmee')!='0000-00-00' AND  _request('date_debut_programmee') != date("Y-m-d H:i:s", mktime($regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1]))){
           $erreurs['date_debut_programmee'] = _T('encheres:date_extistante');
           }


// Pas terminé filtre qui devrait indiqué un minimun pour le nombre quand sont présent des objets qui ne peuvent pas être modifiés
//
// if (_request('nombre')){
// 		if (_request('nombre') > 1){
// 				$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_article='$id_article' ");
// 				$count='0';
// 				$count_not_blocked='0';
// 					while($data = spip_fetch_array($sql)) {
// 					$count = $count+1;
// 					if ($statut=='stand_by' OR $statut=='supprime' OR $statut=='mise_en_vente'){
// 					$count_not_blocked=$count_not_blocked++;};
// 					}
// 				if (_request('nombre') < $count){};
// 			}
// 		elseif (_request('nombre')) {
// 		$erreurs['prix_livraison'] = _T('encheres:prix_valide');
// 			};
// 		}
	if (_request('nombre') AND !ctype_digit(_request('nombre'))){
		$erreurs['nombre'] = _T('encheres:nombre');
				}

	if (_request('prix_livraison') AND !ctype_digit(_request('prix_livraison'))){
		$erreurs['prix_livraison'] = _T('encheres:prix_valide');
				}
	if (count($erreurs))
		$erreurs['message_erreur'] = _T('encheres:erreur_saisie');
	return $erreurs;
	}
}

/* @annotation: Actualisation de la base de donnée */
function formulaires_editer_objets_traiter_dist($option=''){
	$id_objet= _request('id_objet');
	$id_objet_source= _request('id_objet_source');
	$mode = _request('mode');		
	$id_auteur= _request('id_auteur');		
	$id_article= _request('id_article');
	$prix_depart = _request('prix_depart');
	$prix_achat_inmediat = 'prix_depart';
	if (_request('prix_achat_inmediat')) {$prix_achat_inmediat = _request('prix_achat_inmediat');}
	$mode_livraison = _request('mode_livraison');
	$livraison_etranger = _request('livraison_etranger');		
	$prix_livraison = _request('prix_livraison');
	$prix_livraison_etranger = _request('prix_livraison_etranger');		
	$compte_bancaire = _request('compte_bancaire');
	$iban = _request('iban');
	$nombre = _request('nombre');
	$duree = _request('duree');
	$statut = _request('statut');
	$type = _request('type');
	$id_auteur = _request('id_auteur');
	$date_creation = time('Y-m-d G:i:s');
	$date=date('Y-m-d');
	$id_rubrique = _request('id_rubrique');
	$menu = _request('menu');
	$courrier_velo = _request('courrier_velo');
	$remise_vente_automatique = _request('remise_vente_automatique');
	$date_debut_programmee = _request('date_debut_programmee');		
	$exec = _request('exec');			
	if (!$option) {$option = _request('option');}
	$jour =_request('jour');
	$mois =_request('mois');
	$annee =_request('annee');
	$jour_debut_ev =_request('jour_debut_ev');
	$mois_debut_ev =_request('mois_debut_ev');
	$annee_debut_ev =_request('annee_debut_ev');	
	$jour_fin_ev =_request('jour_fin_ev');
	$mois_fin_ev =_request('mois_fin_ev');
	$annee_fin_ev =_request('annee_fin_ev');
	$commentaire =_request('commentaire');	
	$url_retour=_request('url_retour');
	$date_debut_evenement = $annee_debut_ev.'-'.$mois_debut_ev.'-'.$jour_debut_ev;
	$date_fin_evenement = $annee_fin_ev.'-'.$mois_fin_ev.'-'.$jour_fin_ev;		
	$calculer = _request('calculer');
	$joursactifs_tab=(isset($_POST["joursactifs"])) ? $_POST["joursactifs"]:array();
	$count=count ($joursactifs_tab);

	for ( $i=0 ; $i < $count ; $i++ ) {
		$joursactifs = $joursactifs_tab[$i].','.$joursactifs;
		}

	if (!_request('jour') OR _request('jour') == 00)	{
		$date_debut = '0000-00-00 00:00:00' ;
		if($mode=='billetterie'){
			$date_debut = $date;
			}
		}
	else {$date_debut = date('Y-m-d G:i:s',mktime(07,00,00,$mois,$jour,$annee)) ;};
					
	//Gestion de date fin et duree pour la billetterie
			
		
	if($mode=='billetterie'){
		$date_debut_jours = date('d-m-Y',strtotime($date_debut));
 		$date_fin_jours = date('d-m-Y',strtotime($date_fin_evenement));

		$split_jours_debut = explode("-", $date_debut_jours);
		$split_jours_fin = explode("-", $date_fin_jours);

   		$date_debut = mktime(00, 00, 00, $split_jours_debut[1], $split_jours_debut[0], $split_jours_debut[2]) ;   
   				
   		$date_fin = mktime(00, 00, 00, $split_jours_fin[1], $split_jours_fin[0], $split_jours_fin[2]) ;
   				
 		$ratio = ($date_fin-$date_debut)/86400;
 			
 		$duree = ceil($ratio-12);

 		$date_stop_vente = date('Y-m-d', strtotime ("-12 days" .$date_fin_evenement ));
 		$statut_payement_livraison = 'ok';
		}
		
/* @annotation: Si l'id_objet existe déjà, on actualise*/

	if(!$calculer){
		
		if ($id_objet){
	
			$sql1 = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet' ");
				while($data = spip_fetch_array($sql1)) {
				$nombre_orig=$data['nombre'];
				}
		
			if($option!='remise_en_vente'){
			$valeurs=array(		
			'prix_depart' => $prix_depart,
			'prix_achat_inmediat' => $prix_achat_inmediat,
			'montant_mise' => $prix_depart,
			'mode_livraison' => $mode_livraison,
			'livraison_etranger' => $livraison_etranger,
			'prix_livraison_etranger' => $prix_livraison_etranger,	
			'courrier_velo'=> $courrier_velo,
			'prix_livraison' => $prix_livraison,				
			'duree' => $duree,
			'nombre' => $nombre,			
			'id_objet_source' => _request('id_objet_source'),
			'id_article' => $id_article,
			'id_auteur' => $id_auteur,			
			'prix_depart' => $prix_depart,
			'date_debut' => $date_debut,
			'date_debut_evenement' => $date_debut_evenement,
			'date_fin_evenement' => $date_fin_evenement,
			'jours_actifs' => _request('joursactifs'),	
			'date_stop_vente'=>$date_stop_vente,		
			'type' => $type,
			'remise_vente_automatique' => $remise_vente_automatique,
			);
			
			sql_updateq("spip_encheres_objets", $valeurs, "id_objet='$id_objet'");	
			sql_updateq("spip_encheres_objets", $valeurs, "id_objet_source='$id_objet'");
				

			//Controle si besoin d'eliminer ou ajouter des entrées
			
				if ($nombre>$nombre_orig){

					$difference=$nombre-$nombre_orig;

					for($x=0;$x<$difference;$x++) {
					$arg_inser_repetes = array(
						'id_objet' => '',
						'id_objet_source' => _request('id_objet'),
						'id_article' => $id_article,
						'id_auteur' => $id_auteur,
						'prix_depart' => $prix_depart,
						'montant_mise' => $prix_depart,
						'prix_achat_inmediat' => $prix_achat_inmediat,
						'duree' => $duree,
						'date_debut_evenement' => $date_debut_evenement,					
						'date_fin_evenement' => $date_fin_evenement,
						'date_stop_vente'=>$date_stop_vente,	
						'jours_actifs' => $joursactifs,										
						'mode_livraison' => $mode_livraison,
						'livraison_etranger' => $livraison_etranger,					
						'courrier_velo'=> $courrier_velo,
						'prix_livraison' => $prix_livraison,
						'prix_livraison_etranger' => $prix_livraison_etranger,					
						'type' => $type,
						'nombre' => '1',
						'statut' => 'stand_by',
						'remise_vente_automatique' => $remise_vente_automatique						
						);
					$id_objet = sql_insertq('spip_encheres_objets',$arg_inser_repetes);
					}

				}
			elseif($nombre<$nombre_orig){
			
				$difference=$nombre_orig-$nombre;

				spip_query ("DELETE FROM spip_encheres_objets WHERE  id_objet_source='$id_objet' AND statut='stand_by' LIMIT $difference");
				};

		// Invalider les caches
	   include_spip('inc/invalideur');
	   suivre_invalideur("id='id_objet/$id_objet'");
		}

		// Cas de remise en vente permettant le changement de projet
		else{
		$valeurs= array(
			'id_objet' => $id_objet,
			'id_objet_source' => $id_objet_source,			
			'prix_depart' => $prix_depart,
			'duree' => $duree,
			'id_objet_source' => _request('id_objet_source'),
			'id_article' => $id_article,
			'prix_depart' => $prix_depart,
			'montant_mise' => $prix_depart,
			'prix_achat_inmediat' => $prix_achat_inmediat,
			'duree' => $duree,
			'jours_actifs' => $joursactifs,	
			'date_stop_vente'=>$date_stop_vente,	
			'mode_livraison' => $mode_livraison,
			'livraison_etranger' => $livraison_etranger,					
			'courrier_velo'=> $courrier_velo,
			'prix_livraison' => $prix_livraison,
			'prix_livraison_etranger' => $prix_livraison_etranger,					
			'type' => $type,
			'nombre' => $nombre,
			'statut' => 'mise_en_vente',
			'remise_vente_automatique' => $remise_vente_automatique,
			);
			
 			$remettre_en_vente = charger_fonction('remise_vente','inc');
 			$remettre_en_vente('',$valeurs);
			}		
		
		}

/* Si l'id_objet n'existe pas encore on crée les ou l'objets nécessaires*/
	else{
			$arg_inser_produit = array(
			'id_objet' => '',
			'id_objet_source' => '0',
			'id_article' => $id_article,
			'id_auteur' => $id_auteur,
			'prix_depart' => $prix_depart,
			'prix_achat_inmediat' => $prix_achat_inmediat,
			'montant_mise' => $prix_depart,
			'mode_livraison' => $mode_livraison,
			'livraison_etranger' => $livraison_etranger,	
			'courrier_velo'=> $courrier_velo,
			'prix_livraison' => $prix_livraison,
			'prix_livraison_etranger' => $prix_livraison_etranger,
			'duree' => $duree,
			'date_stop_vente'=>$date_stop_vente,	
			'type' => $type,
			'nombre' => $nombre,
			'date_debut' => $date_debut,
			'date_debut_evenement' => $date_debut_evenement,	
			'date_fin_evenement' => $date_fin_evenement,
			'jours_actifs' => $joursactifs,	
			'statut_payement_livraison' => $statut_payement_livraison,					
			'date_creation' => date('Y-m-d G:s:i'),
			'statut' => $statut,
			'remise_vente_automatique' => $remise_vente_automatique			
			);
			$id_objet = sql_insertq('spip_encheres_objets',$arg_inser_produit);

			$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet' ");

			while($data = spip_fetch_array($sql)) {
			$id_objet_objet_source = $data['id_objet'];
					}

				if ($nombre>'1'){
					$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_article='$id_article' ");

					while($data = spip_fetch_array($sql)) {
					$id_objet = $data['id_objet'];
						}
					for($x=0;$x<$nombre-1;$x++) {
					$arg_inser_repetes = array(
					'id_objet' => '',
					'id_objet_source' => $id_objet_objet_source,
					'id_article' => $id_article,
					'id_auteur' => $id_auteur,
					'prix_depart' => $prix_depart,
					'montant_mise' => $prix_depart,
					'livraison_etranger' => $livraison_etranger,
					'prix_achat_inmediat' => $prix_achat_inmediat,
					'duree' => $duree,
					'date_debut_evenement' => $date_debut_evenement,					
					'date_fin_evenement' => $date_fin_evenement,
					'date_stop_vente'=>$date_stop_vente,	
					'jours_actifs' => $joursactifs,		
					'mode_livraison' => $mode_livraison,
					'courrier_velo'=> $courrier_velo,
					'prix_livraison' => $prix_livraison,
					'prix_livraison_etranger' => $prix_livraison_etranger,
					'statut_payement_livraison' => $statut_payement_livraison,	
					'type' => $type,
					'nombre' => '1',
					'statut' => $statut,
					'remise_vente_automatique' => $remise_vente_automatique						
					);
					$id_objet = sql_insertq('spip_encheres_objets',$arg_inser_repetes);
					}

				};
				
				$valeurs = array(
					'chapo' => $commentaire,					
					);
					
			/* Popur les objets de la billetterie on insert un chapo dans l'article*/		
				
			sql_updateq("spip_articles",$valeurs, "id_article= '$id_article'");	

		};

	/* Enregistrement des informations de paiement si mode de livraison !=venir voir &ccedil;i-haut ( si autre mode de livraison, le champ compte_bancaire n'existe pas dans le formulaire */
	
 	if ($compte_bancaire){
 		$id_auteur = _request('id_auteur');
		$paypal = _request('paypal');
		$bic = _request('bic');		
 		spip_query("UPDATE spip_auteurs_elargis SET compte_bancaire='$compte_bancaire', paypal='$paypal', bic='$bic', iban='$iban' WHERE id_auteur='$id_auteur'");
 	};

/* Si on se trouve sur la page vendeur et pas de message erreur present, on renvoie vers la page de l'article du contexte*/


		if (!_request('message_erreur') AND !_request('edition') AND !_request('exec')) { // si pas d'erreur : on renvoie :)
 
 		// construction de la page de retour
 			if (_request('editer')){
						$id_article = _request('id_article');
					$url_retour= generer_url_public("article","id_article=$id_article");
					$url_retour= str_replace('&amp;','&',$url_retour); 
					$url_var='&id_objet='.$id_objet_objet_source;
 					}
 	 			header ('location:'.$url_retour.$url_var);	
 				};
 
}
return;
}


?>