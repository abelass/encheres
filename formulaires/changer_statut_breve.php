<?php
/* @annotation: Charge les valeurs par défaut pour le fomulaire changer statut */
if (!defined("_ECRIRE_INC_VERSION")) return;
function formulaires_changer_statut_breve_charger_dist($id_breve,$url_retour='')
{
	$valeurs = array('statut'=>'','id_breve'=>$id_breve);
	$sql = spip_query( "SELECT * FROM spip_breves WHERE id_breve='$id_breve'");

	while($data = spip_fetch_array($sql)) {
	$valeurs['statut'] = $data['statut'];
		}
	return $valeurs;
	
	// Invalider les caches
	 include_spip('inc/invalideur');
	 suivre_invalideur("id='id_breve/$id_breve'");
}

/* @annotation: Actualisation de la base de donnée */
function formulaires_changer_statut_breve_traiter_dist($id_breve,$url_retour=''){

$url_retour= str_replace('&amp;','&',$url_retour); 

		$statut= _request('statut');
		spip_query ("UPDATE spip_breves SET statut = '$statut' WHERE id_breve='$id_breve'");
if($url_retour) {header('location:'.$url_retour);}

	    	// Invalider les caches
	   		 include_spip('inc/invalideur');
	    	suivre_invalideur("id='id_breve/$id_breve'");
}
?>