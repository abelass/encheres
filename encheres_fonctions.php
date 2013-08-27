<?php

/**
 * Fonctions utiles au plugin Enchères
 *
 * @plugin     Enchères
 * @copyright  2013
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\Encheres\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

// Filtre qui permet de cloture une enchère
function cloturer_enchere($id_encheres_objet,$statut) {
			$sql2 = spip_query( "SELECT * FROM spip_mises WHERE id_encheres_objet='$id_encheres_objet' ORDER BY montant DESC LIMIT 1");
				while($data = spip_fetch_array($sql2)) {
					$id_encherisseur=$data['id_encherisseur'];
					};

			// DÃ©termine l'action suivant si l'enchÃ¨re est restÃ© sans mises (statut: mise_en_vente) ou avec mises (statut : mise_en_vente_active)	
			$actualiser = charger_fonction('actions_enchere_gagne','inc');
			$actualiser('cloture_cron_'.$statut,$id_objet,$id_encherisseur);
			
			
}

// Filtre qui affiche une différence de date

function difference_date ($date_debut,$date_fin,$secondes=86400){

 	$date_debut_jours = date('d-m-Y',strtotime($date_debut));
 	$date_debut_heures = date('G:i:s',strtotime($date_debut));

   	$split_jours_debut = explode("-", $date_debut_jours);
   	$split_heures_debut = explode(":", $date_debut_heures);

 	$date_fin_jours = date('d-m-Y',strtotime($date_fin));
 	$date_fin_heures = date('G:i:s',strtotime($date_fin));

   	$split_jours_fin = explode("-", $date_fin_jours);
   	$split_heures_fin = explode(":", $date_fin_heures);
 
   	$date_fin = mktime($split_heures_fin[0], $split_heures_fin[1], $split_heures_fin[2], $split_jours_fin[1], $split_jours_fin[0], $split_jours_fin[2]) ;
   	$date_debut = mktime($split_heures_debut[0], $split_heures_debut[1], $split_heures_debut[2], $split_jours_debut[1], $split_jours_debut[0], $split_jours_debut[2]) ;   	
 	$date_difference = ($date_fin-$date_debut)/$secondes;
 	
	return $date_difference;
}


/* Fonction qui divise sans virgule */
function divise($texte,$divise){
    $s="";
    $s=ceil($texte / $divise);
    return $s;
    }


/* Filtre qui calcule la date */

function calculer_date($date,$difference,$format=NULL){
	if (!$format) $format='d-m-Y';
	$date=date($format, strtotime ($date."$difference"));

 	return $date;
}


/* Fonction permet de cacluler le temps entre la date actuelle; et une date donnÃ©e */

function difference_jour($date_fin,$mode ='complete'){

	$date_fin_jours = date('Y-m-d',strtotime($date_fin));
	$date_fin_heures = date('G:i:s',strtotime($date_fin));

  	$split_jours = explode("-", $date_fin_jours);
  	$split_heures = explode(":", $date_fin_heures);
  	
  	$date_fin = mktime($split_heures[0]-1, $split_heures[1], $split_heures[2], $split_jours[1], $split_jours[2], $split_jours[0]) ;

  	$date_actuel = time();

  	$date_difference = $date_fin-$date_actuel;
  	
	$mois=date('m',$date_difference)-1;
 	$jours=date('d',$date_difference)-1;
 	$jours_nom=date('d',$date_difference);
	$heures=date('G',$date_difference);
	$minutes=date('i',$date_difference);
	$secondes=date('s',$date_difference);

	if ($mode=='simple'){
		if ($mois !=0 ) $mois_affichage=$mois._T('m').' ';
 		if ($jours !=0) $jours_affichage=$jours._T('j').' ';
		if ($heures !=0) $heures_affichage=$heures._T('h').' ';
		if ($minutes !=0) $minutes_affichage=$minutes._T('min').' ';
		if ($secondes !=0) $secondes_affichage=$secondes._T('s');
		}
	if ($mode=='complete'){
		if ($mois !=0) $mois_affichage=$mois.' '._T('mois').' ';
 		if ($jours !=0){
			if($jours==1) $jours_affichage=$jours.' '._T('jour').' ';
			else $jours_affichage=$jours.' '._T('jours').' ';
			}
		if ($heures !=0) $heures_affichage=$heures.' '._T('h').' ';
		if ($minutes !=0) $minutes_affichage=$minutes.' '._T('min').' ';
		if ($secondes !=0) $secondes_affichage=$secondes.' '._T('s');
		};

	$affichage =$mois_affichage.$jours_affichage.$heures_affichage.$minutes_affichage.$secondes_affichage;

 	return $affichage;

}


// les devises diponibles
function devises(){
	$devises=array(
		'AUD'=>'AUD',	 	 
		'CAD'=>'CAD',	 	 
		'CHF'=>'Fr',	 	 
		'CZK'=>'CZK',	 	 
		'DKK'=>'DKK', 	 
		'EUR'=>'€',	 
		'GBP'=>'£',	 
		'HKD'=>'HKD',	 	 
		'HUF'=>'HUF',	 	 
		'ILS'=>'ILS',	 	 
		'JPY'=>'¥',	 
		'MXN'=>'MXN',	 	 
		'NOK'=>'NOK',	 	 
		'NZD'=>'NZD',	 	 
		'PLN'=>'PLN',	 	 
		'SEK'=>'SEK',	 	 
		'SGD'=>'SGD',	 	 
		'USD'=>'$'
		);

	return $devises;
}

function traduire_devise($code_devise){
	$devises =devises();
	$trad= $devises[$code_devise];
	return $trad;
}

function enchere_gagnant($id_encheres_objet,$filtre=''){
    $gagnant=sql_fetsel('*','spip_encherisseurs LEFT JOIN spip_auteurs USING(id_auteur)','id_encheres_objet='.$id_encheres_objet.' AND gagnant=1');
    if($filtre)$gagnant=$gagnant[$filtre];
    
    return $gagnant;
}
 

//Surcharge de la fonction filtres_prix_formater_dist du plugin prix
if(!function_exists('filtres_prix_formater')){
    function filtres_prix_formater($prix){
    include_spip('inc/config');
    include_spip('inc/cookie');    
    $config=lire_config('encheres');
    $devises=devises();
    
    //Si il y a un cookie 'geo_devise' et qu'il figure parmis les devises diponibles on le prend
    if(isset($_COOKIE['geo_devise']) AND in_array($_COOKIE['geo_devise'],$devises))$devise=$_COOKIE['geo_devise'];
    // Sinon on regarde si il ya une devise defaut valable
    elseif(isset($config['devise']) AND in_array($config['devise'] ,$devises))$devise=$config['devise'];
     // Sinon on met l'Euro
    else $devise='EUR';

    //On met le cookie
    spip_setcookie('geo_devise',$devise, time() + 3660*24*365, '/');
    
    //On détermine la langue du contexte
    if(isset($_COOKIE['spip_lang']))$lang=$_COOKIE['spip_lang'];
    else $lang=lire_config('langue_site');

    // Si PECL intl est présent on dermine le format de l'affichage de la devise selon la langue du contexte
    if(function_exists('numfmt_create')){
        $fmt = numfmt_create($lang, NumberFormatter::CURRENCY );
        $prix = numfmt_format_currency($fmt, $prix,$devise);
    }
    //Sino on formate à la française
    else $prix=$prix.'&nbsp;'.traduire_devise($devise);

    return $prix;
    }
}

function lignes2array($lignes){
    $tableau    = array();
    $lignes     = explode("\n",$lignes);
    foreach ($lignes as $l){
        $donnees= explode(',',$l);
        if ($donnees[1])
            $tableau[trim($donnees[0])] = trim (_T($donnees[1]));
        else
            $tableau[trim($donnees[0])] = '';
    }

    return $tableau;
}