<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_changer_statut_dist(){
	
	$securiser_action = charger_fonction('securiser_action', 'inc');
	$arg = $securiser_action();
	
	$explode= explode("/",$arg);
	$id=trim($explode[0]);
	$statut=trim($explode[1]);
	$option=trim($explode[2]);
		
	switch($statut){
	
		case 'poubelle':
			$supprimer_objet = charger_fonction('supprimer_objet_kidonateur','inc');
			$supprimer_objet ($id,$statut,$option);
		break;
		
		case 'vente_probleme':
			sql_updateq("spip_encheres_objets",array("statut"=>$statut),'id_objet='.$id);
			
			include_spip('inc/invalideur');	
			suivre_invalideur("id='id_objet/$id'");	
	
			$envoyer_message_webmaster= charger_fonction('envoyer_message_webmestre','inc');
			$envoyer_message_webmaster('vente_probleme',$id);	
		
		break;
		
		case 'vente_probleme_traite':
			$montant_mise=sql_getfetsel('prix_depart','spip_encheres_objets','id_objet='.$id);
			sql_updateq("spip_encheres_objets",array("statut"=>'stand_by','id_acheteur'=>0,'date_vente'=>'0000-00-00 00:00:00','date_fin'=>'0000-00-00 00:00:00','date_debut'=>'0000-00-00 00:00:00','montant_mise'=>$montant_mise,'statut_payement_livraison'=>0,'envoi_rappels'=>0,'id_objet_source'=>0),'id_objet='.$id);
			
			include_spip('inc/invalideur');	
			suivre_invalideur("id='id_objet/$id'");	
	
			$envoyer_message_kidonateur= charger_fonction('envoyer_message_kidonateur','inc');
			$envoyer_message_kidonateur('','vente_probleme_traite',$id);	
		
		break;		
		
		
		}

		spip_log("Changer statut : $statut - id : $id  - option : $option",'encheres_actions');		

	
}

?>
