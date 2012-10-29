<?php
$id_trad=_request('lier_trad');
$id_article=_request('id_article');
$lang=_request('lang');
$extra= '';


		spip_query("UPDATE `spip_articles` SET id_trad='$id_trad', langue_choisie='oui' WHERE id_article='$id_trad'");
		spip_query("UPDATE `spip_articles` SET id_trad='$id_trad', langue_choisie='oui', lang='$lang' , extra='$extra 'WHERE id_article='$id_article'");

$url_retour= generer_url_public("article","id_article=$id_article");
$url_retour= str_replace('&amp;','&',$url_retour); 
header ('location:'.$url_retour);

?>