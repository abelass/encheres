<?php
/**
 * Déclarations relatives à la base de données
 *
 * @plugin     Enchères
 * @copyright  2013
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Encheres\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;


/**
 * Déclaration des alias de tables et filtres automatiques de champs
 *
 * @pipeline declarer_tables_interfaces
 * @param array $interfaces
 *     Déclarations d'interface pour le compilateur
 * @return array
 *     Déclarations d'interface pour le compilateur
 */
function encheres_declarer_tables_interfaces($interfaces) {

	$interfaces['table_des_tables']['encheres_objets'] = 'encheres_objets';
	$interfaces['table_des_tables']['mises'] = 'mises';
	$interfaces['table_des_tables']['encherisseurs'] = 'encherisseurs';

	return $interfaces;
}


/**
 * Déclaration des objets éditoriaux
 *
 * @pipeline declarer_tables_objets_sql
 * @param array $tables
 *     Description des tables
 * @return array
 *     Description complétée des tables
 */
function encheres_declarer_tables_objets_sql($tables) {

	$tables['spip_encheres_objets'] = array(
		'type' => 'encheres_objet',
		'principale' => "oui", 
		'table_objet_surnoms' => array('encheresobjet'), // table_objet('encheres_objet') => 'encheres_objets' 
		'field'=> array(
			"id_encheres_objet"  => "bigint(21) NOT NULL",
			"id_rubrique"        => "bigint(21) NOT NULL DEFAULT 0", 
			"id_secteur"         => "bigint(21) NOT NULL DEFAULT 0", 
			"id_encheres_objet_source" => "bigint(21) NOT NULL DEFAULT 0",
			"id_auteur"          => "bigint(21) NOT NULL DEFAULT 0",
			"titre"              => "varchar(25) NOT NULL DEFAULT ''",
            "texte"              => "text NOT NULL DEFAULT ''",
            "descriptif"         => "text NOT NULL DEFAULT ''",			
			"prix_minimum"       => "float (38,2) NOT NULL  DEFAULT '00.0'",
			"prix_actuel"        => "float (38,2) NOT NULL  DEFAULT '00.0'",
			"date_debut"         => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
			"date_fin"           => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",			
			"palier_encherissement" => "float (38,2) NOT NULL DEFAULT '00.0'",
			"date"               => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'", 
			"statut"             => "varchar(20)  DEFAULT '0' NOT NULL", 
			"lang"               => "VARCHAR(10) NOT NULL DEFAULT ''",
			"langue_choisie"     => "VARCHAR(3) DEFAULT 'non'", 
			"id_trad"            => "bigint(21) NOT NULL DEFAULT 0", 
			"maj"                => "TIMESTAMP"
		),
		'key' => array(
			"PRIMARY KEY"        => "id_encheres_objet",
			"KEY id_rubrique"    => "id_rubrique", 
			"KEY id_secteur"     => "id_secteur", 
			"KEY lang"           => "lang", 
			"KEY id_trad"        => "id_trad", 
			"KEY statut"         => "statut", 
		),
		'titre' => "titre AS titre, lang AS lang",
		'date' => "date",
		'champs_editables'  => array('id_auteur', 'titre', 'descriptif', 'texte', 'prix_minimum', 'date_debut','date_fin', 'palier_encherissement'),
		'champs_versionnes' => array( 'id_auteur', 'titre', 'descriptif', 'texte', 'prix_minimum', 'date_debut', 'date_fin', 'date_fin', 'palier_encherissement'),
		'rechercher_champs' => array("titre" => 10, "texte" => 8, "descriptif" => 4),
		'tables_jointures'  => array(),
		'statut_textes_instituer' => array(
			'prepa'    => 'texte_statut_en_cours_redaction',
			'prop'     => 'texte_statut_propose_evaluation',
			'publie'   => 'texte_statut_publie',
			'refuse'   => 'texte_statut_refuse',
			'poubelle' => 'texte_statut_poubelle',
		),
		'statut'=> array(
			array(
				'champ'     => 'statut',
				'publie'    => 'publie',
				'previsu'   => 'publie,prop,prepa',
				'post_date' => 'date', 
				'exception' => array('statut','tout')
			)
		),
		'texte_changer_statut' => 'encheres_objet:texte_changer_statut_encheres_objet', 
		

	);

	$tables['spip_mises'] = array(
		'type' => 'mise',
		'principale' => "oui",
		'field'=> array(
			"id_mise"            => "bigint(21) NOT NULL",
			"id_encheres_objet"  => "bigint(21) NOT NULL DEFAULT 0",
			"id_encherisseur"    => "bigint(21) NOT NULL DEFAULT 0",
			"date"               => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
			"montant"            => "float (38,2) NOT NULL",
			"date"               => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'", 
			"maj"                => "TIMESTAMP"
		),
		'key' => array(
			"PRIMARY KEY"        => "id_mise",
		),
		'titre' => "'' AS titre, '' AS lang",
		'date' => "date",
		'champs_editables'  => array('id_encheres_objet', 'id_encherisseur'),
		'champs_versionnes' => array('id_encheres_objet', 'id_encherisseur'),
		'rechercher_champs' => array(),
		'tables_jointures'  => array(),
		

	);

	$tables['spip_encherisseurs'] = array(
		'type' => 'encherisseur',
		'principale' => "oui",
		'field'=> array(
			"id_encherisseur"    => "bigint(21) NOT NULL",
			"id_auteur"          => "bigint(21) NOT NULL DEFAULT 0",
			"id_encheres_objet"  => "bigint(21) NOT NULL DEFAULT 0",
			"date_creation"      => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'",
			"prix_maximum"       => "float (38,2) NOT NULL",
			"gagnant"            => "tinyint NOT NULL",
			"suivre"             => "tinyint NOT NULL",
			"envoi_avis"         => "tinytext NOT NULL",
			"date_creation"      => "datetime NOT NULL DEFAULT '0000-00-00 00:00:00'", 
			"maj"                => "TIMESTAMP"
		),
		'key' => array(
			"PRIMARY KEY"        => "id_encherisseur",
		),
		'titre' => "'' AS titre, '' AS lang",
		'date' => "date_creation",
		'champs_editables'  => array(),
		'champs_versionnes' => array(),
		'rechercher_champs' => array(),
		'tables_jointures'  => array(),
		

	);

	return $tables;
}

/*/
 * Les champs extras
 */
function encheres_declarer_champs_extras($champs = array()) {
  include_spip('inc/config');
  include_spip('encheres_fonctions');
  
  $roles=lignes2array(lire_config('encheres/roles',array()));
    

  $champs['spip_auteurs']['role'] = array(
      'saisie' => 'selection',
      'options' => array(
            'nom' => 'role', 
            'label' => _T('encheres:label_role'), 
            'sql' => "varchar(30) NOT NULL DEFAULT ''",
            'datas' => $roles,
            'restrictions'=>array('voir' => array('auteur' => ''),//Tout le monde peut voir
                        'modifier' => array('auteur' => 'webmestre')),//Seuls les webmestres peuvent modifier
      ),
  );
  

  return $champs;   
  
  
}
?>