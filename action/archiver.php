<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_archiver_dist(){
	
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();
	
	$explode= explode("/",$arg);
	$id_objet=trim($explode[0]);
	$champ=trim($explode[1]);
	
	sql_update('spip_encheres_objets',array($champ=>'1'),'id_objet='.$id_objet);
	
	spip_log("Archiver statut :  id_objet : $id_objet",'encheres_actions');	
		
	// Invalider les caches
	include_spip('inc/invalideur');
	suivre_invalideur("id='id_objet/$id_objet'");	

}

?>
