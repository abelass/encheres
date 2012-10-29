<?php

/* @annotation: Charge les valeurs par défaut pour le fomulaire editer objet */

function formulaires_editer_objets_charger_dist(){
	$valeurs = array('id_article'=>'','id_objet'=>'','id_objet_source'=>'','prix_depart'=>'','prix_achat_inmediat'=>'','mode_livraison'=>'','prix_livraison'=>'','nombre'=>'','duree'=>'','date_debut'=>'','statut'=>'','type'=>'','exec'=>'');

	$valeurs['id_article'] =_request('id_article');
	$valeurs['exec'] = _request('exec');
	$valeurs['voir'] = _request('voir');
	$id_article=$valeurs['id_article'];
	$valeurs['date_debut']= date('Y-m-d 00:00:00');
	$valeurs['statut']= "stand_by";

		if (!_request('id_objet')){
			$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_article='$id_article' AND id_objet_source='0' ");
				while($data = spip_fetch_array($sql)) {
				$valeurs['id_objet']=$data['id_objet'];
				$valeurs['id_objet_source']=$data['id_objet_source'];
				$valeurs['prix_depart']=$data['prix_depart'];
				$valeurs['prix_achat_inmediat']=$data['prix_achat_inmediat'];
				$valeurs['mode_livraison']=$data['mode_livraison'];
				$valeurs['prix_livraison']=$data['prix_livraison'];
				$valeurs['nombre']=$data['nombre'];
				$valeurs['duree']=$data['duree'];
				$valeurs['date_debut']=$data['date_debut'];
				$valeurs['statut']=$data['statut'];
				$valeurs['type']=$data['type'];
							}
			}
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
				$valeurs['prix_livraison']=$data['prix_livraison'];
				$valeurs['nombre']=$data['nombre'];
				$valeurs['date_creation']=$data['date_creation'];
				$valeurs['duree']=$data['duree'];
				$valeurs['date_debut']=$data['date_debut'];
				$valeurs['statut']=$data['statut'];
				$valeurs['type']=$data['type'];
			}
		};

	return $valeurs;
};

/* @annotation: Validation des champs obligatoires */
function formulaires_editer_objets_verifier_dist(){
	$erreurs = array();
	/* @annotation: le champ prix_livraison est obligatoire si la marcyhandise est livré ou envoyé*/
	if(_request('mode_livraison')!='venir'){
	// verifier que les champs obligatoires sont bien la :
	foreach(array('prix_depart','mode_livraison','prix_livraison','nombre','duree','date_debut','statut','type') as $obligatoire)
		if (!_request($obligatoire)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';
	}
	else{
	// verifier que les champs obligatoires sont bien la :
	foreach(array('prix_depart','mode_livraison','nombre','duree','date_debut','statut','type') as $obligatoire)
		if (!_request($obligatoire)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';
	};
	if (count($erreurs))
		$erreurs['message_erreur'] = 'Votre saisie contient des erreurs !';
	return $erreurs;
}


function formulaires_editer_objets_traiter_dist(){
		$id_objet= _request('id_objet');
		$id_article= _request('id_article');
		$prix_depart = _request('prix_depart');
		$prix_achat_inmediat = _request('prix_achat_inmediat');
		$mode_livraison = _request('mode_livraison');
		$prix_livraison = _request('prix_livraison');
		$nombre = _request('nombre');
		$duree = _request('duree');
		$date_debut = _request('date_debut');
		$date_fin = date('Y-m-d 00:00:00', strtotime ($date_debut."+$duree day"));
		$statut = _request('statut');
		$type = _request('type');

	if ($id_objet){
	spip_query("UPDATE `spip_encheres_objets` SET date_debut='$date_debut', date_fin='$date_fin',prix_depart='$prix_depart',prix_achat_inmediat='$prix_achat_inmediat',mode_livraison='$mode_livraison',prix_livraison='$prix_livraison',duree='$duree',nombre='$nombre',statut='$statut',type='$type'  WHERE id_objet='$id_objet'");

			$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_article='$id_article' ");
			$count='0';
				while($data = spip_fetch_array($sql)) {
			$count = $count+1;
					}
				if ($nombre>$count){
					$nombre = $nombre-$count;
					for($x=0;$x<$nombre-1;$x++) {
					$arg_inser_repetes = array(
					'id_objet' => '',
					'id_objet_source' => _request('id_objet'),
					'id_article' => $id_article,
					'prix_depart' => $prix_depart,
					'prix_achat_inmediat' => $prix_achat_inmediat,
					'mode_livraison' => $mode_livraison,
					'prix_livraison' => $prix_livraison,
					'duree' =>  _request('duree'),
					'type' => $type,
					'nombre' => '1',
					'date_debut' => $date_debut,
					'date_fin' => date('Y-m-d 00:00:00', strtotime ($date_debut."+$duree day")),
					'statut' => 'stand_by',
					);
					$id_objet = sql_insertq('spip_encheres_objets',$arg_inser_repetes);
					}
				}
				elseif($nombre<$count) {
					$nombre = $count-$nombre;
					$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_article='$id_article' AND statut='stand_by' AND id_objet_source !=0 ORDER BY id_objet DESC LIMIT $nombre");
					while($data = spip_fetch_array($sql)) {
					$id_objet=$data['id_objet'];
					spip_query("DELETE FROM spip_encheres_objets WHERE id_objet=$id_objet");
						}

				};
		}
	else{
			$arg_inser_produit = array(
			'id_objet' => '',
			'id_objet_source' => '0',
			'id_article' => $id_article,
			'prix_depart' => $prix_depart,
			'prix_achat_inmediat' => $prix_achat_inmediat,
			'mode_livraison' => $mode_livraison,
			'prix_livraison' => $prix_livraison,
			'type' => $type,
			'nombre' => $nombre,
			'date_debut' => $date_debut,
			'date_fin' => date('Y-m-d 00:00:00', strtotime ($date_debut."+$duree day")),
			'date_creation' => date('Y-m-d 00:00:00'),
			'statut' => $statut,
			);
			$id_objet = sql_insertq('spip_encheres_objets',$arg_inser_produit);
				if ($nombre>'1'){
					$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_article='$id_article' ");
					while($data = spip_fetch_array($sql)) {
					$id_objet = $data['id_objet'];
					}
					for($x=0;$x<$nombre-1;$x++) {
					$arg_inser_repetes = array(
					'id_objet' => '',
					'id_objet_source' => $id_objet,
					'id_article' => $id_article,
					'prix_depart' => $prix_depart,
					'prix_achat_inmediat' => $prix_achat_inmediat,
					'mode_livraison' => $mode_livraison,
					'prix_livraison' => $prix_livraison,
					'type' => $type,
					'nombre' => '1',
					'date_debut' => $date_debut,
					'date_fin' => date('Y-m-d 00:00:00', strtotime ($date_debut."+$duree day")),
					'statut' => 'stand_by',
					);
					$id_objet = sql_insertq('spip_encheres_objets',$arg_inser_repetes);
					}

				};
		};

	}



?>