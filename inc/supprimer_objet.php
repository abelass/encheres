<?php

function inc_supprimer_objet_dist ($id_objet,$id_article,$type=''){

	// Si pas spécifié autrement supprime également les objets multis
				
	if($type!='unique'){
	sql_delete ('spip_encheres_objets', "statut NOT LIKE 'vente_termine%' AND statut NOT LIKE 'vendu%' AND id_article=$id_article");	
		   		
	// Ecrit le log.
	spip_log('Supprimer objet multi: id_objet: '.$id_objet. ', id_article:' .$id_article,'encheres_actions');			
	}
	else{
	// Supprimer l'objet si pas vendu ou vente terminé
	sql_delete ('spip_encheres_objets', "statut NOT LIKE 'vente_termine%' AND statut NOT LIKE 'vendu%' AND id_objet=$id_objet");	
	
	// Ecrit le log.
	spip_log('Supprimer objet unique: id_objet: '.$id_objet. ', id_article:' .$id_article,'encheres_actions');			
	
	}
	// Supprimer l'article si l'objet n'est pas vendu ou vente terminé, ainsi que les infos liés à l'article.
			  								
	if(!$objet_restant=sql_getfetsel('id_objet','spip_encheres_objets',"id_article=$id_article")) {
	
  		sql_delete ('spip_mots_articles', "id_article=$id_article");
    				
			//Si ils existent des traductions on elimine également tous liés aux traductions

 			$sql = sql_select('*','spip_articles',"id_trad=$id_article");
  			
 				while($data = sql_fetch($sql)) {
 					$id_art_trad = $data['id_article'];
					sql_delete ('spip_auteurs_articles', "id_article=$id_art_trad");
					sql_delete ('spip_documents_liens', "id_objet=$id_art_trad");
					sql_delete ('spip_visites_articles', "id_article=$id_art_trad");
 					}
 				sql_delete ('spip_auteurs_articles', "id_article=$id_article");
 				sql_delete ('spip_documents_liens', "id_objet=$id_article");
 				sql_delete ('spip_visites_articles', "id_article=$id_article");
 				sql_delete ('spip_articles', "id_trad=$id_article OR id_article=$id_article");
 				
			// Ecrit le log.
			spip_log('Supprimer donnees articles de l\'objet: id_objet: '.$id_objet. ', id_article:' .$id_article,'encheres_actions');				
			}			
						
						
			// Invalider les caches
	  		include_spip('inc/invalideur');
	   		suivre_invalideur("id='id_objet/$id_objet'");
	   		

}

?>
