<?php
		$id_article=_request('eliminer');
		$id_auteur=_request('id_auteur');
		spip_query ("DELETE FROM spip_articles  WHERE  id_article='$id_article'");
 		spip_query ("DELETE FROM spip_mots_articles WHERE  id_article='$id_article'");
 		spip_query ("DELETE FROM spip_auteurs_articles  WHERE  id_article='$id_article'");
 		spip_query ("DELETE FROM spip_documents_liens  WHERE  id_objet='$id_article'");

		$url_retour= generer_url_public("auteur","id_auteur=$id_auteur");
		$url_retour= str_replace('&amp;','&',$url_retour); 
		header('Location:'.$url_retour.'&var_mode=calcul');
?>