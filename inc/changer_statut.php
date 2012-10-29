<?php

/* @annotation: Charge les valeurs par défaut pour le fomulaire changer statut */
if (!defined("_ECRIRE_INC_VERSION")) return;
function formulaires_changer_statut_charger_dist($id_objet)
{
	$valeurs = array('statut'=>'','id_objet'=>$id_objet,'date_debut'=>'');
	$valeurs['statut'] = _request('statut');

	$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet'");

	while($data = spip_fetch_array($sql)) {
	$valeurs['statut'] = $data['statut'];
	$valeurs['date_debut'] = $data['date_debut'];

		}
	return $valeurs;
}




/* @annotation: Actualisation de la base de donnée */
function formulaires_changer_statut_traiter_dist(){
		$id_objet= _request('id_objet');
		$statut= _request('statut');
		$supprimer= _request('supprimer');
		$date_debut= _request('date_debut');

$sql = spip_query( "SELECT * FROM spip_encheres_objets WHERE id_objet='$id_objet'");
	while($data = spip_fetch_array($sql)) {
		$id_article=$data['id_article'];
		$duree=$data['duree'];
		$id_auteur=$data['id_auteur'];
		$mode_livraison=$data['mode_livraison'];
					}
		if ($supprimer){

			// On elimine tous liés à l'article de base

			spip_query ("DELETE FROM spip_encheres_objets WHERE id_objet='$id_objet' OR id_objet_source='$id_objet'");
  			spip_query ("DELETE FROM spip_mots_articles WHERE  id_article='$id_article'");

			//Si ils existe des traductions on elimine également tous lies aux traduction

 			$sql = spip_query( "SELECT * FROM spip_articles WHERE id_trad='$id_article' ");
 				while($data = spip_fetch_array($sql)) {
 				$id_art_trad = $data['id_article'];
  			spip_query ("DELETE FROM spip_auteurs_articles  WHERE  id_article='$id_art_trad'");
  			spip_query ("DELETE FROM spip_documents_liens  WHERE  id_objet='$id_art_trad'");
  			spip_query ("DELETE FROM spip_visites_articles  WHERE  id_objet='$id_art_trad'");
 							}

 			spip_query ("DELETE FROM spip_auteurs_articles  WHERE  id_article='$id_article'");
 			spip_query ("DELETE FROM spip_documents_liens  WHERE  id_objet='$id_article'");
 			spip_query ("DELETE FROM spip_visites_articles  WHERE  id_article='$id_article'");
 			spip_query ("DELETE FROM spip_articles  WHERE  id_trad='$id_article' OR id_article='$id_article' ");
			}

		elseif ($statut == 'mise_en_vente'){
			
         if ($date_debut == '0000-00-00 00:00:00'){$date_debut = date('Y-m-d G:i:s');};

			//provisoire, pour les inscriptions avant le 17 septembre, à supprimer après
			$date_debut = date('Y-m-d G:i:s', mktime(date('G'),date('i'),date('s'),9,17,2009));

			$date_fin = date('Y-m-d G:i:s', strtotime ($date_debut."$duree day"));

			if($mode_livraison=='venir') {
			$statut_payement_livraison='ok';
				}
			spip_query ("UPDATE spip_encheres_objets SET statut = '$statut', date_debut = '$date_debut', date_fin = '$date_fin', statut_payement_livraison = '$statut_payement_livraison'  WHERE (statut='stand_by') AND id_article='$id_article' ORDER BY id_objet LIMIT 3");

			//PREPARE L'ENVOIE DES MAILS
			$sql = spip_query( "SELECT * FROM spip_auteurs_articles WHERE id_article='$id_article'");
			while($data = spip_fetch_array($sql)) {
				$id_auteur=$data['id_auteur'];
				$sql = spip_query( "SELECT * FROM spip_auteurs WHERE id_auteur='$id_auteur'");
					while($data = spip_fetch_array($sql)) {
						$email=$data['email'];
						$nom=$data['nom'];
					}
					}

			//Mail de confirmation visiteur
			$envoyer_message_visiteur = charger_fonction('envoyer_message_visiteur','inc');
			$envoyer_message_visiteur($email,'mettre_en_vente',$id_objet);

			//Le mail pour le webmaster

			$envoyer_inscription_webmaster = charger_fonction('envoyer_message_webmaster','inc');
			$envoyer_inscription_webmaster('mettre_en_vente',$id_objet,$id_auteur);
			}
		elseif ($statut =='stand_by'){
			spip_query ("UPDATE spip_encheres_objets SET statut = '$statut'  WHERE (statut='mise_en_vente' OR statut='supprime') AND id_article='$id_article'");
			};

	if(_request('exec') AND $supprimer){
	$url_site = $GLOBALS['meta']["adresse_site"];
	$url_retour='/ecrire';
	header ('location:'.$url_site.$url_retour);
}
// 		$id_article = _request('id_article');
// 		$url_retour= generer_url_public("article","id_article=$id_article");
// 		$url_retour= str_replace('&amp;','&',$url_retour); 
// 		header ('location:'.$url_retour);
}
?>