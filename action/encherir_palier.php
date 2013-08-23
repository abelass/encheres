<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function action_encherir_palier_dist($arg=null) {	
	if (is_null($arg)){
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
	}
	
    list($id_encheres_objet,$palier_encherissement)=explode('|',$arg);
    
  



	return array('message_ok'=>'ok');
}

?>
