<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
function encheres_affiche_milieu($flux) {
   $exec = $flux["args"]["exec"];
	if ($exec=='articles'){
		$id_article = $flux["args"]["id_article"];
      $contexte = array('id_article'=>$id_article);
      $ret = "<div id='pave_selection'>";
      $ret .= recuperer_fond("prive/editer_objets", $contexte);
      $ret .= "</div>";
      $flux["data"] .= $ret;
	};
    return $flux;
}
?>
