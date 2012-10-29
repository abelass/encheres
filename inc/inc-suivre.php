<?php
$id_auteur=$GLOBALS['auteur_session']['id_auteur'];
$id_objet=_request('id_objet');
$date_creation = date('Y-m-d G:i:s');

$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet'");
	while($data = spip_fetch_array($sql)) {
		$id_article = $data['id_article'];
		}

$sql = spip_query( "SELECT * FROM spip_encheres_encherisseurs WHERE id_objet='$id_objet' AND id_encherisseur='$id_auteur'");
	while($data = spip_fetch_array($sql)) {
		$id_client = $data['id_client'];
		}

if (!$id_client){
	$arg_inser_client = array(
	'id_client' => '',
	'id_objet' => $id_objet,
	'id_encherisseur' => $id_auteur,
	'date_creation' => $date_creation,
	'suivre' => '1'
			);
				$id_client = sql_insertq('spip_encheres_encherisseurs',$arg_inser_client);

	echo '<li class="suivre"><img src="images/puceorange.jpg" alt="" />'._T('suivi_objet_explicatif').'</li>';
		}
		
		// Invalider les caches
	   include_spip('inc/invalideur');
	   suivre_invalideur("id='id_objet/$id_objet'");


 		
 		
?>