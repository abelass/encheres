<?php
/**
 * Préchargement des formulaires d'édition de encheres_objet
 *
 * @plugin     Enchères
 * @copyright  2013
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Encheres\Formulaires
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/precharger_objet');

/**
 * Retourne les valeurs à charger pour un formulaire d'édition d'un encheres_objet
 *
 * Lors d'une création, certains champs peuvent être préremplis
 * (c'est le cas des traductions) 
 *
 * @param string|int $id_encheres_objet
 *     Identifiant de encheres_objet, ou "new" pour une création
 * @param int $id_rubrique
 *     Identifiant éventuel de la rubrique parente
 * @param int $lier_trad
 *     Identifiant éventuel de la traduction de référence
 * @return array
 *     Couples clés / valeurs des champs du formulaire à charger.
**/
function inc_precharger_encheres_objet_dist($id_encheres_objet, $id_rubrique=0, $lier_trad=0) {
	return precharger_objet('encheres_objet', $id_encheres_objet, $id_rubrique, $lier_trad, 'titre');
}

/**
 * Récupère les valeurs d'une traduction de référence pour la création
 * d'un encheres_objet (préremplissage du formulaire). 
 *
 * @note
 *     Fonction facultative si pas de changement dans les traitements
 * 
 * @param string|int $id_encheres_objet
 *     Identifiant de encheres_objet, ou "new" pour une création
 * @param int $id_rubrique
 *     Identifiant éventuel de la rubrique parente
 * @param int $lier_trad
 *     Identifiant éventuel de la traduction de référence
 * @return array
 *     Couples clés / valeurs des champs du formulaire à charger
**/
function inc_precharger_traduction_encheres_objet_dist($id_encheres_objet, $id_rubrique=0, $lier_trad=0) {
	return precharger_traduction_objet('encheres_objet', $id_encheres_objet, $id_rubrique, $lier_trad, 'titre');
}


?>