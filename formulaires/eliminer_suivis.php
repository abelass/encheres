<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_eliminer_suivis_charger_dist($id_auteur){
	$valeurs = array('id_auteur'=>$id_auteur);
	return $valeurs;
}


/*Elimination de la base de donées */
function formulaires_eliminer_suivis_traiter_dist($id_auteur){
reset($_POST); 
	while (list($key, $val) = each($_POST)) { 
		if(preg_match('/id_objet/', $key)){
			$id_objet=str_replace('id_objet_','',$key); 
			$objet_final=_request('id_objet_'.$id_objet);
			spip_query ("DELETE FROM spip_encheres_encherisseurs  WHERE  id_encherisseur='$id_auteur' AND id_objet='$id_objet'");
			}

		}
			
	// Invalider les caches
	 include_spip('inc/invalideur');
	 suivre_invalideur("id='id_objet/$id_objet'");

}

?>