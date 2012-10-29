<?php
$id_mot=_request('eliminer');
$id_article=_request('id_article');
spip_query("DELETE FROM spip_mots_articles WHERE id_mot=$id_mot AND id_article=$id_article");
?>