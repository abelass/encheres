<?php

/* @annotation: Charge les valeurs par défaut pour le fomulaire editer objet */
if (!defined("_ECRIRE_INC_VERSION")) return;
function formulaires_gerer_mots_charger_dist()
{
	$valeurs = array('id_article'=>'','id_mot'=>'','act'=>'');
	$valeurs['id_article'] =_request('id_article');
	$valeurs['id_mot'] = _request('id_mot');
	$valeurs['act'] = _request('act');
	return $valeurs;
}

/* @annotation: Validation des champs obligatoires */
function formulaires_gerer_mots_verifier_dist(){
	$erreurs = array();
	foreach(array('id_article') as $obligatoire)
		if (!_request($obligatoire)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';
	
	if (count($erreurs))
		$erreurs['message_erreur'] = 'Votre saisie contient des erreurs !';
	return $erreurs;
}


/* @annotation: Actualisation de la base de donnée */
function formulaires_gerer_mots_traiter_dist(){
		$id_article= _request('id_article');
		$id_mot= _request('id_mot');
		$act = _request('act');

					$arg_inser = array(
					'id_mot' => _request('id_mot'),
					'id_article' => _request('id_article'),
					);
					$insert = sql_insertq('spip_mots_articles',$arg_inser);

}
?>