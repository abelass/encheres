<?php

if (!defined("_ECRIRE_INC_VERSION")) return;
	
function encheres_declarer_tables_principales($tables_principales){

$encheres_objets = array(
	"id_objet"	=> "bigint(21) NOT NULL",
	"id_objet_source"	=> "bigint(21) NOT NULL",
	"id_article"	=> "bigint(21) NOT NULL",
	"id_auteur"	=> "bigint(21) NOT NULL",
	"id_acheteur"	=> "bigint(21) NOT NULL",
 	"prix_depart" => "bigint(21) NOT NULL",
	"prix_achat_inmediat" => "tinytext NOT NULL",
 	"montant_mise" => "bigint(21) NOT NULL",
 	"mode_livraison"	=> "tinytext NOT NULL",
 	"livraison_etranger"	=> "tinytext NOT NULL", 	
 	"courrier_velo"	=> "tinytext NOT NULL",
	"prix_livraison" => "bigint(21) NOT NULL",
	"prix_livraison_etranger" => "bigint(21) NOT NULL",	
 	"nombre" => "bigint(21) NOT NULL",
 	"date_creation"	=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
 	"duree" => "bigint(21) NOT NULL",
 	"date_debut"	=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
 	"remise_en_vente"	=> "smallint(1) NULL",
 	"date_debut_evenement"	=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
 	"date_fin_evenement"	=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL", 
  	"jours_actifs"	=> "text NOT NULL", 	 		 	
 	"date_fin"	=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
 	"date_stop_vente"	=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
 	"date_vente"	=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
 	"maj"=> "TIMESTAMP",
 	"statut"	=> "tinytext NOT NULL",
 	"type"	=> "tinytext NOT NULL",
 	"paiement_paypal"	=> "bool NOT NULL",
 	"paiement_virement" => "bool NOT NULL",
 	"evaluation_vendeur"	=> "smallint(1) NULL",
 	"evaluation_acheteur"	=> "smallint(1) NULL",
 	"statut"	=> "tinytext NOT NULL",
 	"statut_payement_livraison"	=> "tinytext NOT NULL",
 	"date_paiement_livraison"	=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
 	"statut_payement_objet"	=> "tinytext NOT NULL",
 	"date_paiement_objet"	=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
 	"statut_livraison"	=> "tinytext NOT NULL",
 	"date_livraison"	=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
 	"envoi_rappels"	=> "varchar(30) NOT NULL",
 	"remise_vente_automatique" => "bool NOT NULL",
  	"archive_kidonateur" => "bool NOT NULL",	
  	"archive_acheteur" => "bool NOT NULL",
  	"archive_association" => "bool NOT NULL",  		  	
	);
	
$encheres_objets_key = array(
	"PRIMARY KEY"		=> "id_objet",
	"KEY id_objet_source"	=> "id_objet_source",
	"KEY id_article"	=> "id_article",
	"KEY id_acheteur" => "id_acheteur",
	"KEY id_auteur" => "id_acheteur",
	);

$encheres_objets_join = array(
	"id_objet"		=> "id_objet",
	"id_article"		=> "id_article",
	"id_auteur"		=> "id_auteur",
	"id_acheteur"		=> "id_auteur",	
	);

$encheres_mises = array(
	"id_mise"	=> "bigint(21) NOT NULL",
	"id_objet"	=> "bigint(21) NOT NULL",
	"id_encherisseur"	=> "bigint(21) NOT NULL",
	"date_mise"	=> "TIMESTAMP",
	"montant_mise" => "bigint(21) NOT NULL",
	);
	
$encheres_mises_key = array(
	"PRIMARY KEY"		=> "id_mise",
	"KEY id_objet" => "id_objet",
	"KEY id_encherisseurr" => "id_encherisseur",
	);

$encheres_mises_join = array(
	"id_objet"	=> "id_objet",
	"id_encherisseur"	=> "id_auteur",	
	);

$encheres_encherisseurs = array(
 	"id_client"	=> "bigint(21) NOT NULL",
 	"id_objet"	=> "bigint(21) NOT NULL",
 	"id_encherisseur"	=> "bigint(21) NOT NULL",
 	"date_creation"	=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
 	"prix_maximum" => "bigint(21) NOT NULL",
 	"gagne"	=> "bool NOT NULL",
 	"suivre"	=> "bool NOT NULL",
 	"envoi_avis"	=> "tinytext NOT NULL",
 	);
	
$encheres_encherisseurs_key = array(
 	"PRIMARY KEY"		=> "id_client",
 	"KEY id_objet" => "id_objet",
 	"KEY id_encherisseurr" => "id_encherisseur",
 	);

$encheres_encherisseurs_join = array(
 	"id_objet"	=> "id_objet",
 	"id_encherisseur"	=> "id_auteur",		
 	);

$encheres_evaluations = array(
	"id_auteur"	=> "bigint(21) NOT NULL",
	"vendeur_positif"	=> "bigint(21) NOT NULL",	
	"vendeur_neutre"	=> "bigint(21) NOT NULL",	
	"vendeur_negatif"	=> "bigint(21) NOT NULL",	
	"acheteur_positif"	=> "bigint(21) NOT NULL",	
	"acheteur_neutre"	=> "bigint(21) NOT NULL",	
	"acheteur_negatif"	=> "bigint(21) NOT NULL",		
	"objets_acheteur"	=> "bigint(21) NOT NULL",
 	"objets_vendeur" => "bigint(21) NOT NULL",
 	"score" => "bigint(21) NOT NULL" 	
	);
	
$encheres_evaluations_key = array(
	"PRIMARY KEY"		=> "id_auteur",
	);

$encheres_evaluations_join = array(
	"id_auteur"		=> "id_auteur",
	);
	
$encheres_kidonathons = array(
	"id_kidonathon"		=> "bigint(21) NOT NULL",
	"titre"				=> "varchar(255) NOT NULL",	
	"montant"			=> "bigint(21) NOT NULL",	
 	"date_creation"		=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",	
	"maj"				=> "TIMESTAMP",			
	);
	
$encheres_kidonathons_key = array(
	"PRIMARY KEY"		=> "id_kidonathon",
	);

$encheres_kidonathons_join = array(
	"id_kidonathon"		=> "id_kidonathon",
	);	


$tables_principales['spip_encheres_objets'] = array(
	'field' => &$encheres_objets,
	'key' => &$encheres_objets_key,
	'join' => &$encheres_objets_join
	);

$tables_principales['spip_encheres_mises'] = array(
	'field' => &$encheres_mises,
	'key' => &$encheres_mises_key,
	'join' => &$encheres_mises_join
	);

 $tables_principales['spip_encheres_encherisseurs'] = array(
 	'field' => &$encheres_encherisseurs,
 	'key' => &$encheres_encherisseurs_key,
 	'join' => &$encheres_encherisseurs_join
 	);
 	
  $tables_principales['spip_encheres_evaluations'] = array(
 	'field' => &$encheres_evaluations,
 	'key' => &$encheres_evaluations_key,
 	'join' => &$encheres_evaluations_join
 	);
 	
   $tables_principales['spip_encheres_kidonathons'] = array(
 	'field' => &$encheres_kidonathons,
 	'key' => &$encheres_kidonathons_key,
 	'join' => &$encheres_kidonathons_join
 	);		
$tables_principales['spip_rubriques']['field']['desactiver'] = "tinytext NOT NULL";
           
return $tables_principales;
};
?>
