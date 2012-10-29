<?php




function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array(),$lang,$option){


setlocale(LC_TIME, $lang);

if ($lang=='fr')setlocale(LC_ALL, 'fr_BE');
if ($lang=='nl')setlocale(LC_ALL, 'nl_BE');

	$first_of_month = gmmktime(0,0,0,$month,1,$year);
	#remember that mktime will automatically correct if invalid dates are entered
	# for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998
	# this provides a built in "rounding" feature to generate_calendar()

	$day_names = array(); #generate all the day names according to the current locale
	for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday
		$day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name

	list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
	$weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
	$title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names

	#Begin calendar. Uses a real <caption>. See http://diveintomark.org/archives/2002/07/03
	@list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable
	if(!$option){
		if($p) $p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;';
		if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>';
	}
	$calendar = '<table class="calendar">'."\n".
		'<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</caption>\n<tr>";

	if($day_name_length){ #if the day names should be shown ($day_name_length > 0)
		#if day_name_length is >3, the full name of the day will be printed
		foreach($day_names as $d)
			$calendar .= '<th abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>';
		$calendar .= "</tr>\n<tr>";
	}

	if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days
	for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){
		if($weekday == 7){
			$weekday   = 0; #start a new week
			$calendar .= "</tr>\n<tr>";
		}
		if(isset($days[$day]) and is_array($days[$day])){
			@list($link, $classes, $content,$selected) = $days[$day];
			if(is_null($content))  $content  = $day;
			if(!$option){
			$calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>').
				($link ? '<a href="'.htmlspecialchars($link).'">'.$content.'</a>' : $content).'</td>';
				}
			else{
			$calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>').
				($link ? '<input type="checkbox" '.$selected.' name="joursactifs[]" value="'.htmlspecialchars($link).'"><label>'.$content.'</label>' : $content).'</td>';
			}
		}
		else $calendar .= "<td>$day</td>";
	}
	if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days

	return $calendar."</tr>\n</table>\n";
}


function inc_affich_jours_spectacles_dist($MM_traite, $AAAA_traite,$lang,$DD_traite='',$mm_fin='',$dd_fin='',$aaaa_fin='',$option='',$jours_actifs=''){


	$date=date('Y-m-d');


	$date_test_periode_debut = $AAAA_traite . '-' . $MM_traite . '-01';
	$date_test_periode_fin = date ('Y-m-d', mktime(0, 0, 0, $MM_traite, 1, $AAAA_traite)); // un mois plus tard
	if($mm_fin)$date_test_periode_fin = date ('Y-m-d', mktime(0, 0, 0, $mm_fin, $dd_fin, $aaaa_fin));
	$tableau_jours = array() ;	

	// .......................................................................
	// Flèches de "mois précédent" et "mois suivant"
	
	// 1) Début du mois suivant :
	if ($MM_traite == 12 )
	{
		$mois_next = 1;
		$annee_next = $AAAA_traite + 1;
	}
	else
	{
		$mois_next = $MM_traite + 1;
		$annee_next = $AAAA_traite ;
	}

	//$next = '?mois=' . $mois_next . '&annee=' . $annee_next . '&mois_chgt=1' ;
	$mois_next = str_pad($mois_next, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
	$annee_next = str_pad($annee_next, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne

	// Recherche de la valeur du dernier jour du mois afin de préremplir la date de fin de recherche
	$valeur_dernier_jour_mois = date("t",mktime(0,0,0,$mois_next + 1,0,$annee_next));
	$next = '?page=achat&id_groupe1=80&date_debut=' . $annee_next . '-' . $mois_next . '-01';
	
	// 1) mois précédant :
	if ($MM_traite == 1 )
	{
		$mois_prev = 12;
		$annee_prev = $AAAA_traite - 1;
	}
	else
	{
		$mois_prev = $MM_traite - 1;
		$annee_prev = $AAAA_traite ;
	}

	$mois_prev = str_pad($mois_prev, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
	$annee_prev = str_pad($annee_prev, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne

	// Recherche de la valeur du dernier jour du mois afin de préremplir la date de fin de recherche
	$valeur_dernier_jour_mois = date("t",mktime(0,0,0,$mois_prev + 1,0,$annee_prev));
	$prev = '?page=achat&id_groupe1=80&date_debut=' . $annee_prev . '-' . $mois_prev . '-01';

	
	// echo '<p>'.$prev . ' <<==>> ' . $next . '</p>';
	$pn = array('&lt;&lt;'=> $prev, '&gt;&gt;'=> $next);
// .......................................................................

	// Initialiser le tableau. (Car un simple "else" n'aurait pas été)
	$j=1;
	
	for ($j=1 ; $j<=31 ; $j++)
	{
		$JJ_traite = str_pad($j, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
		settype($JJ_traite, "integer"); // Pour éviter problèmes de foncion "calebdar" avec les nombres précédés de "0"	
		$tableau_jours[$JJ_traite] = array(NULL,'linked-day non_event_cal',$JJ_traite);
	}
	// $date_test_periode_debut = premiere date debut $date_test_periode_fin : derniers date fin
	
	if(!$option){
		$reponse_fct = spip_query("SELECT * FROM spip_encheres_objets WHERE statut='mise_en_vente' ") ;
		
		
		while ($donnees_fct = mysql_fetch_array($reponse_fct))
		{ 
			$date_fin_evenement = $donnees_fct ['date_fin_evenement'];

			$j=1;
			for ($j=1 ; $j<=31 ; $j++)
			{
				// Composer la chaine qui sera cherchée dans la DB :
				$MM_traite = str_pad($MM_traite, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
				$JJ_traite = str_pad($j, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
				$date_traite = $AAAA_traite.'-'.$MM_traite.'-'.$JJ_traite ;
				settype($JJ_traite, "integer"); // Pour éviter problèmes de foncion "calebdar" avec les nombres précédés de "0"	
				$jours_actifs_event = $donnees_fct ['jours_actifs'];
	
				$jours_actifs_event = explode(",", $jours_actifs_event);
			
				if (in_array($date_traite, $jours_actifs_event) AND $date_traite >=$date )
				{
					// echo '<br>id('.$donnees_fct ['id_event'] .') '.$date_traite.' y est '; // test
					// jour ACTIF
					//$link = '?jour='.$j.'&mois='.$MM_traite.'&annee='.$AAAA_traite ;
					$j = str_pad($j, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
					$MM_traite = str_pad($MM_traite, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
					$link = '?page=achat&id_groupe1=80&date_sel='.$AAAA_traite .'-' . $MM_traite . '-' . $j.'&date_debut='.$AAAA_traite .'-' . $MM_traite . '-' . $j;

					$tableau_jours[$JJ_traite] = array($link,'linked-day event_cal',$JJ_traite);
				}
			}
		}
	}
	elseif($option=='editer_objets'){
		$debut=1;
		if($DD_traite>1)$debut=$DD_traite;
		if($dd_fin<31)$fin=$dd_fin;

		$jours_actifs = 
	
		$joursactifs_tab=(isset($_POST["joursactifs"])) ? $_POST["joursactifs"]:array();
	
		$count=count ($joursactifs_tab);
				
		$ja=array();
			for ( $i=0 ; $i < $count ; $i++ ) {
				$joursactifs = $joursactifs_tab[$i];

				$ja[$i]= $joursactifs;
				}

			for ($j=$debut ; $j<=$dd_fin ; $j++)
			{
				// Composer la chaine qui sera cherchée dans la DB :
				$MM_traite = str_pad($MM_traite, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
				$JJ_traite = str_pad($j, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
				$date_traite = $AAAA_traite.'-'.$MM_traite.'-'.$JJ_traite ;
				$date_fin = $aaaa_fin.'-'.$mm_fin.'-'.$dd_fin ;				
				settype($JJ_traite, "integer"); // Pour éviter problèmes de foncion "calebdar" avec les nombres précédés de "0"	
				$jours_actifs_event = $donnees_fct ['jours_actifs'];
	
				$jours_actifs_event = explode(",", $jours_actifs_event);
			
				if (in_array($date_traite, $ja)){
				
				
					// echo '<br>id('.$donnees_fct ['id_event'] .') '.$date_traite.' y est '; // test
					// jour ACTIF
					//$link = '?jour='.$j.'&mois='.$MM_traite.'&annee='.$AAAA_traite ;
					$j = str_pad($j, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
					$MM_traite = str_pad($MM_traite, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
					$link = $AAAA_traite .'-' . $MM_traite . '-' . $j;
				$selected ='checked="true"';	

				$tableau_jours[$JJ_traite] = array($link,'linked-day event_cal',$JJ_traite,$selected);
				
				}
				else {
								
					// echo '<br>id('.$donnees_fct ['id_event'] .') '.$date_traite.' y est '; // test
					// jour ACTIF
					//$link = '?jour='.$j.'&mois='.$MM_traite.'&annee='.$AAAA_traite ;
					$j = str_pad($j, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
					$MM_traite = str_pad($MM_traite, 2, "0", STR_PAD_LEFT) ;  // Complète la chaîne
					$link = $AAAA_traite .'-' . $MM_traite . '-' . $j;
					
				$tableau_jours[$JJ_traite] = array($link,'linked-day event_cal',$JJ_traite);}
			}
	
		}
	echo generate_calendar($AAAA_traite, $MM_traite, $tableau_jours, 2, NULL, 1, $pn,$lang,$option); // Affichage du calendrier
	echo '<br />' ;
}


?>