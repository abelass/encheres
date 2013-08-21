<?php
/**
 * Gestion du formulaire de d'édition de encheres_objet
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
 * @param int|string $id_encheres_objet
 *     Identifiant du encheres_objet. 'new' pour un nouveau encheres_objet.
 * @param int $id_rubrique
 *     Identifiant de la rubrique parente (si connue)
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant éventuel d'un encheres_objet source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du encheres_objet, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return string
 *     Hash du formulaire
 */
function formulaires_editer_encheres_objet_identifier_dist($id_encheres_objet='new', $id_rubrique=0, $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	return serialize(array(intval($id_encheres_objet)));
}

/**
 * Chargement du formulaire d'édition de encheres_objet
 *
 * Déclarer les champs postés et y intégrer les valeurs par défaut
 *
 * @uses formulaires_editer_objet_charger()
 *
 * @param int|string $id_encheres_objet
 *     Identifiant du encheres_objet. 'new' pour un nouveau encheres_objet.
 * @param int $id_rubrique
 *     Identifiant de la rubrique parente (si connue)
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant éventuel d'un encheres_objet source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du encheres_objet, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Environnement du formulaire
 */
function formulaires_editer_encheres_objet_charger_dist($id_encheres_objet='new', $id_rubrique=0, $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
	$valeurs = formulaires_editer_objet_charger('encheres_objet',$id_encheres_objet,$id_rubrique,$lier_trad,$retour,$config_fonc,$row,$hidden);
    $valeurs['date_actuelle']=date('Y-m-d H:i:s');
	return $valeurs;
}

/**
 * Vérifications du formulaire d'édition de encheres_objet
 *
 * Vérifier les champs postés et signaler d'éventuelles erreurs
 *
 * @uses formulaires_editer_objet_verifier()
 *
 * @param int|string $id_encheres_objet
 *     Identifiant du encheres_objet. 'new' pour un nouveau encheres_objet.
 * @param int $id_rubrique
 *     Identifiant de la rubrique parente (si connue)
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant éventuel d'un encheres_objet source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du encheres_objet, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Tableau des erreurs
 */
function formulaires_editer_encheres_objet_verifier_dist($id_encheres_objet='new', $id_rubrique=0, $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){
         $verifier = charger_fonction('verifier', 'inc');
     $champs = array('date_debut','date_fin');
     $erreurs=array();
     foreach($champs AS $champ){
          $normaliser = null;
         if ($erreur = $verifier(_request($champ), 'date', array('normaliser'=>'datetime'), $normaliser)) {
         $erreurs[$champ] = $erreur;
         // si une valeur de normalisation a ete transmis, la prendre.
         } elseif (!is_null($normaliser) and _request($champ)) {
         set_request($champ, $normaliser);
         }
         else set_request($champ,'0000-00-00 00:00:00');
     }

    
    $erreurs=array_merge($erreurs,formulaires_editer_objet_verifier('encheres_objet',$id_encheres_objet, array('id_auteur', 'titre', 'date_debut', 'date_fin','id_parent')));

    if(strtotime(_request('date_debut'))>=strtotime(_request('date_fin')))$erreurs['date_fin']=_T('encheres_objet:erreur_date_fin_evenement');

	return $erreurs;
}

/**
 * Traitement du formulaire d'édition de encheres_objet
 *
 * Traiter les champs postés
 *
 * @uses formulaires_editer_objet_traiter()
 *
 * @param int|string $id_encheres_objet
 *     Identifiant du encheres_objet. 'new' pour un nouveau encheres_objet.
 * @param int $id_rubrique
 *     Identifiant de la rubrique parente (si connue)
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant éventuel d'un encheres_objet source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du encheres_objet, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Retours des traitements
 */
function formulaires_editer_encheres_objet_traiter_dist($id_encheres_objet='new', $id_rubrique=0, $retour='', $lier_trad=0, $config_fonc='', $row=array(), $hidden=''){

	return formulaires_editer_objet_traiter('encheres_objet',$id_encheres_objet,$id_rubrique,$lier_trad,$retour,$config_fonc,$row,$hidden);
}


?>