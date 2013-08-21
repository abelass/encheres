<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2009                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

// chargement des valeurs par defaut des champs du formulaire
function formulaires_recherche_charger_dist($lien_filtre = NULL,$lien_arg = NULL){
	$lien = $lien_filtre ? $lien_filtre : $lien_arg;
	if ($GLOBALS['spip_lang'] != $GLOBALS['meta']['langue_site'])
		$lang = $GLOBALS['spip_lang'];
	else
		$lang='';
	

	return 
		array(
			'action' => ($lien ? $lien : generer_url_public('achat')), # action specifique, ne passe pas par Verifier, ni Traiter
			'recherche' => _request('recherche'),
			'lang' => $lang,
			'id_groupe1' => _request('id_groupe1'),
			'id_groupe2' => _request('id_groupe2'),
			'id_groupe3' => _request('id_groupe3'),
			'id_mot' => _request('id_mot'),
			'id_groupe_theme' => _request('id_groupe_theme'),
			'id_mot_cat_objet' => _request('id_mot_cat_objet'),
			'trie' => _request('trie'),
			'type' => _request('type'),
			'pays' => _request('pays'),			
			'region' => _request('region'),
			'code_postal' => _request('code_postal'),
			'id_commune' => _request('id_commune'),									
			'id_rubrique' => _request('id_rubrique'),
			'recherche_form' => _request('recherche_form'),
			'prix_max' => _request('prix_max'),
			'id_auteur' => _request('id_auteur'),
			'id_mot_pays' => _request('id_mot_pays'),
			'recherche_etendue' => _request('recherche_etendue')

		);
	
}

?>
