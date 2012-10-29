<?php
function envoyer_mails(){
	$acheteur = sql_fetsel('*','spip_auteurs',array('id_auteur='.sql_quote($id_encherisseur)));
		
	$contexte=array(
		'objet'=>'',
		'projet'=>'rien',
		'asso'=>'rien',
		'commune'=>'rien',
		'pays_kidonateur'=>'rien',	
		'id_mot_article'=>'rien',				
		'acheteur'=>$acheteur,				
		'artobjet'=>'',					
		'kidonateur'=>'rien',																				
		);
		
	$envoyer_message_acheteur = charger_fonction('envoyer_message_acheteur','inc');
	$envoyer_message_acheteur('','objet_supprime',$id_objet,$contexte);	

}

function inc_supprimer_objet_kidonateur_dist ($id,$statut,$option=''){

	switch ($option){
		case 'kidonateur_tout':
			$sql=sql_select("id_objet,statut","spip_encheres_objets",'statut NOT LIKE "vente_termine" AND id_acheteur=0 AND  id_auteur='.sql_quote($id));		
				
			$objets=array();	
			while($row=sql_fetch($sql)){
				$objets[]=$row['id_objet'];
				}
				
			spip_log('Changer statut objets auteur test : '.$statut.' id_objet : '.serialize($objets),'encheres_actions');	
			adapter_statut($objets,$statut);	
				
		break;
		default:
			adapter_statut($id,$statut);
		}
}

function adapter_statut($id_objet,$statut){

	$objets=$id_objet;
	$id=$id_objet;
	
	if(is_array($id_objet)){
		$objets=implode(',',$id_objet);
		$id=$id_objet[0];
		}

	$encherisseurs= sql_select('id_encherisseur','spip_encheres_mises','id_objet IN ('.$objets.')','',array('montant_mise DESC'),'1');
		
	while ($row=sql_fetch($encherisseurs)){
		 envoyer_mails($row['id_encherisseur']);
		}

	sql_updateq("spip_encheres_objets",array("statut"=>$statut),'id_objet IN ('.$objets.')');
	
	spip_log("Changer statut principal : $statut id_objet : $objets",'encheres_actions');
	
	include_spip('inc/invalideur');	
	suivre_invalideur("id='id_objet/$id'");	
	
	
	// on adapte le statuts des objets liées sauf les vendus et les cloturés
	
	/*
	$sql = sql_select('id_objet',"spip_encheres_objets", 'statut NOT LIKE "vente_termine" AND (id_objet_source IN ('.$objets.') or id_objet IN ('.$objets.') o)');
	
	$objets_lies=array();	
	while($row=sql_fetch($sql)){
		if($row['statut']!='vendu')$objets_lies[]=$row['id_objet'];
		elseif($row['id_acheteur']==0)$objets_lies[]=$row['id_objet'];
		}
	
	spip_log("Changer statut : $statut id_objet : $id_objet",'encheres_actions');
	if(!$teste=sql_fetch($sql)){
		$id_objet_source= sql_getfetsel('id_objet_source',"spip_encheres_objets",'id_objet='.sql_quote($id_objet));
		 $sql = sql_select('id_objet',"spip_encheres_objets", 'statut NOT IN ("vente_termine","vendu") AND id_objet_source='.sql_quote($id_objet_source));
		 sql_updateq("spip_encheres_objets",array("statut"=>$statut),array("id_objet = ".sql_quote($id_objet_source)));
		 }
	
	while ($row=sql_fetch($sql)){
		$id_objet=$row['id_objet'];
		sql_updateq("spip_encheres_objets",array("statut"=>$statut),array("id_objet = ".sql_quote($id_objet)));
		suivre_invalideur("id='id_objet/$id_objet'");	
	}*/
}			
?>