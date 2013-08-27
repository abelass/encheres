<?php
/* Fonction qui gères les actions après une vente gagné*/

function inc_actions_enchere_gagne_dist($type,$id_encheres_objet,$id_encherisseur='',$contexte=''){
     $date = date('Y-m-d G:i:s');
     $statut = 'vendu';
     $gagne='1';
     $id_objet_actuel=$id_encheres_objet;
     
		
		// Les infos acheteur
		if($id_encherisseur)$acheteur= sql_select('*','spip_auteurs','id_auteur='.sql_quote($id_encherisseur));
        else {
            $acheteur= sql_fetsel('*','spip_encherisseurs,spip_auteurs','spip_encherisseurs.id_encheres_objet='.sql_quote($id_encheres_objet).' AND spip_encherisseurs.gagnant=1');
            $id_encherisseur=$acheteur['id_auteur'];
        }

        
        $email = $acheteur['email'];

		// Les infos de l'objet
		$objet=sql_fetsel('*','spip_encheres_objets',array('id_encheres_objet='.sql_quote($id_encheres_objet)));


		$date_fin = $objet['date_fin'];
		$statut_2 = $objet['statut'];	
		
	   spip_log($type,'teste')	;
		if ($type!='cloture_cron_publie'){

            if($prix_minimum=$objet['prix_minimum']>$objet['prix_actuel'])$statut = 'non_vendu';
					
			$set=array(
				' statut'=>$statut,
				 'date_vente'=>$date,
				 'id_acheteur' => $id_encherisseur
				);

			sql_updateq('spip_encheres_objets',$set,'id_encheres_objet='.sql_quote($id_encheres_objet));

			sql_updateq('spip_encherisseurs',array('gagnant'=>$gagne),'id_encheres_objet='.sql_quote($id_encheres_objet).' AND id_auteur='.sql_quote($id_encherisseur));	
			
			
    		// On assemble les infos pour l'envoi des mails	
    		$contexte=array(
    			'acheteur'=>$acheteur,	
    			);	
    		
            if($statut=='vendu'){
                // Notifications
                $notifications = charger_fonction('notifications', 'inc', true);
        
    
                // Envoyer à l'encherisseur et au webmaster
                $notifications('cloture_webmaster',$id_encheres_objet, $options);
        
                $options['email']=$email;
                $options['statut']=$statut;
                $notifications('cloture_encherisseur',$id_encheres_objet, $options);
            }	

            }
		else{
			$statut='non_vendu';			
			sql_updateq('spip_encheres_objets',array("statut" => $statut),'id_encheres_objet='.sql_quote($id_encheres_objet));
			};
						
        $id_objet = $id_objet_actuel;
				
				//Enregistre le log
				if ($type == 'cloture_mise_inmediat'){spip_log("Vente inmediate : action cloture de l'enchère: $id_objet",'encheres');};
				if ($type == 'cloture_cron_mise_en_vente_active'){spip_log("CRON : action cloture de l'enchère active: $id_objet",'encheres_cron');};
				if ($type == 'cloture_cron_mise_en_vente'){spip_log("CRON : action cloture de l'enchère sans mises: $id_objet",'encheres_cron');};

						
		// Invalider les caches
	   include_spip('inc/invalideur');
	   suivre_invalideur("id='encheres_objet/$id_encheres_objet'");
								
}
?>