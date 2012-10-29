<?php
$id_objet=_request('id_objet');
$id_article_supp=_request('supprimer');

$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet' ");
	while($data = spip_fetch_array($sql)) {
			$id_art_or = $data['id_article'];
					}

$url_retour= generer_url_public("article","id_article=$id_art_or");

$url_retour= str_replace('&amp;','&',$url_retour); 
$url_var='&id_objet='.$id_objet.'&edition=oui';	
$url_retour = $url_retour.$url_var;

header ('location:'.$url_retour);

spip_query("DELETE FROM spip_articles WHERE id_article=$id_article_supp");
spip_query("DELETE FROM spip_auteurs_articles WHERE id_article=$id_article_supp");
?>