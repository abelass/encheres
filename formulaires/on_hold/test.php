<?php

include_once('../../../ecrire/inc/utils.php');
include_once('../../../ecrire/inc/filtres.php');
//include_once('../../../ecrire/inc/charsets.php');
//include_once('../../../ecrire/inc/envoyer_mail.php');
//include_once('../../../ecrire/inc/traduire.php');

function chercher_module_lang($module, $lang = '') {
	if ($lang)
		$lang = '_'.$lang;

	// 1) dans un repertoire nomme lang/ se trouvant sur le chemin
	if ($f = find_in_path($module.$lang.'.php', 'lang/'))
		return $f;

	// 2) directement dans le chemin (old style, uniquement pour local)
	return ($module == 'local')
		? find_in_path('local'.$lang. '.php')
		: '';
}


$testtt = chercher_module_lang('encheres','nl');
var_dump($testtt);

$fich = find_in_path('encheres_fr.php','lang/');
var_dump($fich);



//envoyer_mail_assoc('4506');



function envoyer_mail_assoc($item_number){
    	
//  récupération de l'adresse mail de l'assoc
    connex();
    $requete =  "SELECT spip_auteurs.email, spip_auteurs_elargis.langue
                        FROM spip_encheres_objets,spip_articles,spip_rubriques,spip_auteurs,spip_auteurs_elargis
                        WHERE id_objet ='$item_number'
                        AND spip_encheres_objets.id_article = spip_articles.id_article
                        AND spip_articles.id_rubrique = spip_rubriques.id_rubrique
                        and spip_auteurs.id_auteur = spip_rubriques.id_auteur
                        LIMIT 1";
    $resultat = mysql_query($requete) or die("erreur mysql : " . mysql_error());
    $data = mysql_fetch_array($resultat);
    mysql_close();
    $email = $data[0];
    $lang = $data[1];
     
     echo _T('encheres:compte_bancaire','nl')."<br />";
     echo "$lang<br />$email";  
        
    //$email = 'jean-pierre@y-media.be';
    $sujet = _T('encheres:sujet_validation_paypal');
    $entete = '';
    $message = 'un test pour les message payal';
    $pied = 'un pied';
    $from = 'info@kidonaki.be';
    $header ="Content-Type: text/html; charset=UTF-8\n".
                                                    "Content-Transfer-Encoding: 8bit\n" .
                                                    "MIME-Version: 1.0\n";
                                                        
                                                        
    $send_mail = envoyer_mail($email,$sujet,$entete.$message.$pied,$from,$header);
    return $send_mail;
}











function connex(){
    $conex = mysql_connect('localhost','kidonaki','vxKcQJzw6cxrgxx') or die("Impossible de se connecter : " . mysql_error());
    $db_conex = mysql_select_db('ki2naki') or die("Impossible de se connecter : " . mysql_error());
}


function envoyer_mail($email, $sujet, $texte, $from = "", $headers = "") {
	global $hebergeur, $queue_mails;
	include_spip('inc/charsets');
	include_spip('inc/filtres');

	if (!email_valide($email)) return false;
	if ($email == _T('info_mail_fournisseur')) return false; // tres fort

	// Traiter les headers existants
	if (strlen($headers)) $headers = trim($headers)."\n";

	// Fournir si possible un Message-Id: conforme au RFC1036,
	// sinon SpamAssassin denoncera un MSGID_FROM_MTA_HEADER

	$email_envoi = $GLOBALS['meta']["email_envoi"];
	if (email_valide($email_envoi)) {
		preg_match('/(@\S+)/', $email_envoi, $domain);
		$mid = 'Message-Id: <' . time() . '_' . rand() . '_' . md5($email . $texte) . $domain[1] . ">\n";
	} else {
		spip_log("Meta email_envoi invalide. Le mail sera probablement vu comme spam.");
		$email_envoi = $email;
		$mid = '';
	}
	if (!$from) $from = $email_envoi;

	// ceci est la RegExp NO_REAL_NAME faisant hurler SpamAssassin
	//if (preg_match('/^["\s]*\<?\S+\@\S+\>?\s*$/', $from))
	//	$from .= ' (' . str_replace(')','', translitteration(str_replace('@', ' at ', $from))) . ')';

	// Et maintenant le champ From:
	$headers .= "From: $from\n";

	// indispensable pour les sites qui colle d'office From: serveur-http
	// sauf si deja mis par l'envoyeur
	if (strpos($headers,"Reply-To:")===FALSE)
		$headers .= "Reply-To: $from\n";

	$charset = $GLOBALS['meta']['charset'];

	// Ajouter le Content-Type et consort s'il n'y est pas deja
	if (strpos($headers, "Content-Type: ") === false)
		$headers .=
		"Content-Type: text/plain; charset=$charset\n".
		"Content-Transfer-Encoding: 8bit\n" .
		"MIME-Version: 1.0\n";

	$headers .= $mid;




	// Ajouter le \n final
	if ($headers = trim($headers)) $headers .= "\n";
	if (function_exists('wordwrap'))
		$texte = wordwrap($texte);



	switch($hebergeur) {
	case 'lycos':
		$queue_mails[] = array(
			'email' => $email,
			'sujet' => $sujet,
			'texte' => $texte,
			'headers' => $headers);
		return true;
	case 'free':
		return false;
	default:
		return @mail($email, $sujet, $texte, $headers);
	}

}



?>