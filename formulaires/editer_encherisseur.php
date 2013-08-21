<?php
/**
 * Gestion du formulaire de d'édition de encherisseur
 *
 * @plugin     Enchères
 * @copyright  2013
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Encheres\Formulaires
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/actions');
include_spip('inc/editer');

/**
 * Identifier le formulaire en faisant abstraction des paramètres qui ne représentent pas l'objet edité
 *
 * @param int|string $id_encherisseur
 *     Identifiant du encherisseur. 'new' pour un nouveau encherisseur.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant éventuel d'un encherisseur source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du encherisseur, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return string
 *     Hash du formulaire
 */
function formulaires_editer_encherisseur_identifier_dist($id_encherisseur='new', $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	return serialize(array(intval($id_encherisseur)));
}

/**
 * Chargement du formulaire d'édition de encherisseur
 *
 * Déclarer les champs postés et y intégrer les valeurs par défaut
 *
 * @uses formulaires_editer_objet_charger()
 *
 * @param int|string $id_encherisseur
 *     Identifiant du encherisseur. 'new' pour un nouveau encherisseur.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant éventuel d'un encherisseur source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du encherisseur, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Environnement du formulaire
 */
function formulaires_editer_encherisseur_charger_dist($id_encherisseur='new', $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	$valeurs = formulaires_editer_objet_charger('encherisseur',$id_encherisseur,'',$lier_trad,$retour,$config_fonc,$row,$hidden);
	return $valeurs;
}

/**
 * Vérifications du formulaire d'édition de encherisseur
 *
 * Vérifier les champs postés et signaler d'éventuelles erreurs
 *
 * @uses formulaires_editer_objet_verifier()
 *
 * @param int|string $id_encherisseur
 *     Identifiant du encherisseur. 'new' pour un nouveau encherisseur.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant éventuel d'un encherisseur source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du encherisseur, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Tableau des erreurs
 */
function formulaires_editer_encherisseur_verifier_dist($id_encherisseur='new', $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	return formulaires_editer_objet_verifier('encherisseur',$id_encherisseur);
}

/**
 * Traitement du formulaire d'édition de encherisseur
 *
 * Traiter les champs postés
 *
 * @uses formulaires_editer_objet_traiter()
 *
 * @param int|string $id_encherisseur
 *     Identifiant du encherisseur. 'new' pour un nouveau encherisseur.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant éventuel d'un encherisseur source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du encherisseur, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Retours des traitements
 */
function formulaires_editer_encherisseur_traiter_dist($id_encherisseur='new', $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	return formulaires_editer_objet_traiter('encherisseur',$id_encherisseur,'',$lier_trad,$retour,$config_fonc,$row,$hidden);
}


?>