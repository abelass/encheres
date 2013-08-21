<?php
/**
 * Utilisations de pipelines par Enchères
 *
 * @plugin     Enchères
 * @copyright  2013
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Encheres\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;
	

/*
 * Un fichier de pipelines permet de regrouper
 * les fonctions de branchement de votre plugin
 * sur des pipelines existants.
 */


/**
 * Ajouter les objets sur les vues de rubriques
 *
 * @pipeline affiche_enfants
 * @param  array $flux Données du pipeline
 * @return array       Données du pipeline
**/
function encheres_affiche_enfants($flux) {
	if ($e = trouver_objet_exec($flux['args']['exec'])
		AND $e['type'] == 'rubrique'
		AND $e['edition'] == false) {

		$id_rubrique = $flux['args']['id_rubrique'];
		$lister_objets = charger_fonction('lister_objets', 'inc');

		$bouton = '';
		if (autoriser('creerencheres_objetdans', 'rubrique', $id_rubrique)) {
			$bouton .= icone_verticale(_T("encheres_objet:icone_creer_encheres_objet"), generer_url_ecrire("encheres_objet_edit", "id_rubrique=$id_rubrique"), "encheres_objet-24.png", "new", "right")
					. "<br class='nettoyeur' />";
		}

		$flux['data'] .= $lister_objets('encheres_objets', array('titre'=>_T('encheres_objet:titre_encheres_objets_rubrique') , 'id_rubrique'=>$id_rubrique, 'par'=>'titre'));
		$flux['data'] .= $bouton;

	}
	return $flux;
}


/**
 * Ajout de liste sur la vue d'un auteur
 *
 * @pipeline affiche_auteurs_interventions
 * @param  array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function encheres_affiche_auteurs_interventions($flux) {
	if ($id_auteur = intval($flux['args']['id_auteur'])) {

		$flux['data'] .= recuperer_fond('prive/objets/liste/encherisseurs', array(
			'id_auteur' => $id_auteur,
			'titre' => _T('encherisseur:info_encherisseurs_auteur')
		), array('ajax' => true));

	}
	return $flux;
}


?>