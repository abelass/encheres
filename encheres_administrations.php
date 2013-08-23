<?php
/**
 * Fichier gérant l'installation et désinstallation du plugin Enchères
 *
 * @plugin     Enchères
 * @copyright  2013
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Encheres\Installation
 */

if (!defined('_ECRIRE_INC_VERSION')) return;
include_spip('inc/cextras');
include_spip('base/encheres');

/**
 * Fonction d'installation et de mise à jour du plugin Enchères.
 *
 * Vous pouvez :
 *
 * - créer la structure SQL,
 * - insérer du pre-contenu,
 * - installer des valeurs de configuration,
 * - mettre à jour la structure SQL 
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @param string $version_cible
 *     Version du schéma de données dans ce plugin (déclaré dans paquet.xml)
 * @return void
**/
function encheres_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();

	
    cextras_api_upgrade(encheres_declarer_champs_extras(),$maj['create']);
	$maj['create'][] = array('maj_tables', array('spip_encheres_objets', 'spip_mises', 'spip_encherisseurs'));



	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}


/**
 * Fonction de désinstallation du plugin Enchères.
 * 
 * Vous devez :
 *
 * - nettoyer toutes les données ajoutées par le plugin et son utilisation
 * - supprimer les tables et les champs créés par le plugin. 
 *
 * @param string $nom_meta_base_version
 *     Nom de la meta informant de la version du schéma de données du plugin installé dans SPIP
 * @return void
**/
function encheres_vider_tables($nom_meta_base_version) {
	sql_drop_table("spip_encheres_objets");
	sql_drop_table("spip_mises");
	sql_drop_table("spip_encherisseurs");

	# Nettoyer les versionnages et forums
	sql_delete("spip_versions",              sql_in("objet", array('encheres_objet', 'mise', 'encherisseur')));
	sql_delete("spip_versions_fragments",    sql_in("objet", array('encheres_objet', 'mise', 'encherisseur')));
	sql_delete("spip_forum",                 sql_in("objet", array('encheres_objet', 'mise', 'encherisseur')));
    cextras_api_vider_tables(encheres_declarer_champs_extras());
	effacer_meta($nom_meta_base_version);
}

?>