<?php

/*======================================================================================================================

                Traitement et validation des payements par PAYPAL   (validation IPN)
                https://www.paypal.com/fr/cgi-bin/webscr?cmd=p/acc/ipn-info-outside
                
                par Jean-Pierre pour Y-media, avril 2010

=======================================================================================================================*/






include_once('../../../ecrire/inc/utils.php');
include_once('../../../ecrire/inc/filtres.php');
//include_once('../../../ecrire/inc/charsets.php');
//include_once('../../../ecrire/inc/envoyer_mail.php');
include_once('../../../ecrire/inc/traduire.php');


    
// ----------------    Premier traitement retour paypal - récupéré sur le net ---------------------------------


//lire le formulaire provenant du système PayPal et ajouter 'cmd'
$req = 'cmd=_notify-validate';
    
foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}

// renvoyer au système PayPal pour validation
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$receiver_id = $_POST['receiver_id'];
$payer_email = $_POST['payer_email'];
$id_user = $_POST['custom'];
$address_city = $_POST['address_city'];
$address_country = $_POST['address_country'];
$address_state = $_POST['address_state'];
$address_country_code = $_POST['address_country_code'];
$address_name = $_POST['address_name'];
$address_status = $_POST['address_status'];
$address_street = $_POST['address_street'];
$address_zip = $_POST['address_zip'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$payer_business_name = $_POST['payer_business_name'];
$payer_id = $_POST['payer_id'];
$payer_status= $_POST['payer_status'];
$residence_country= $_POST['residence_country'];

if (!$fp) {
// ERREUR HTTP
} else {
     //$valid = validation_paypal();
    fputs ($fp, $header . $req);
    while (!feof($fp)) {
        $res = fgets ($fp, 1024);
        if (strcmp ($res, "VERIFIED") == 0) {
            // transaction valide
                           // vérifier que payment_status a la valeur Completed
                if ( $payment_status == "Completed") {
                    // vérifier que txn_id n'a pas été précédemment traité: Créez une fonction qui va interroger votre base de données
                    if (VerifIXNID($txn_id) == 0) {
                        // vérifier que receiver_email est votre adresse email PayPal principale
                        if (verif_business($item_number,$receiver_email) == 0) {
                            
                            if(verif_amount($item_number,$amount) == 0){
                                 // traiter le paiement
                                $erreur = ''; 
                            }
                            else{
                                // Mauvais montant
                                $erreur = 'erreur_montant';  
                            }   
                         }
			  else {
				// Mauvaise adresse email paypal
                                $erreur = 'erreur_email_paypal';  
			  }
			}
			else {
				// ID de transaction déjà utilisé
                                $erreur = 'erreur_txn_id_double';
					}
			}
		  else {
		        	// Statut de paiement: Echec
                                $erreur = 'erreur_echec';              
		  }
            
        }
        else if (strcmp ($res, "INVALID") == 0) {
            // Transaction invalide
            $erreur = 'erreur_INVALID';
        }
    }
    if($erreur ==''){
        $maj = mise_a_jour($item_number);
    }
    $valid = enregistrement_paypal($erreur,$txn_id,$receiver_email,$receiver_id,$payer_email,$item_number,$amount,$address_city,$address_country,$address_state,$address_country_code,$address_name,$address_status,$address_street,$address_zip,$first_name,$last_name,$payer_business_name,$payer_id,$payer_status,$residence_country);
    if($valid == true)
        $send_mail = envoyer_mail_assoc($item_number);
    fclose ($fp);
}


// ---------------------  FIN CODE RÉCUPÉRATION DONNÉES PAYPAL   --------------------------------

// fonction de mise à jour de  la table spip_encheres_objets

function mise_a_jour($item_number){
    connex();
    //$requete = "UPDATE spip_encheres_objets SET statut_payement_objet = 'ok',paiement_paypal = '1' WHERE id_objet = $item_number";
    $requete = "UPDATE spip_encheres_objets SET statut = 'vente_termine', statut_payement_objet='ok', paiement_paypal='1', date_paiement_objet='$date'   WHERE  id_objet='$item_number'";
    $resultat = mysql_query($requete) or die("erreur mysql : " . mysql_error());
    mysql_close();
}




// fonction d'enregistrement des données dans la table paypal

function enregistrement_paypal($erreur,$txn_id,$receiver_email,$receiver_id,$payer_email,$item_number,$amount,$address_city,$address_country,$address_state,$address_country_code,$address_name,$address_status,$address_street,$address_zip,$first_name,$last_name,$payer_business_name,$payer_id,$payer_status,$residence_country){

    $conex = connex();
    
    // récupération de l'id_auteur de l'association et de l'id_acheteur kidonaki
    
    $requete =  "SELECT spip_auteurs_elargis.id_auteur,spip_encheres_objets.id_acheteur
                        FROM spip_encheres_objets,spip_articles,spip_rubriques,spip_auteurs_elargis
                        WHERE id_objet ='$item_number'
                        AND spip_encheres_objets.id_article = spip_articles.id_article
                        AND spip_articles.id_rubrique = spip_rubriques.id_rubrique
                        and spip_auteurs_elargis.id_auteur = spip_rubriques.id_auteur
                        LIMIT 1";
    $resultat = mysql_query($requete) or die("erreur mysql : " . mysql_error());
    $data = mysql_fetch_array($resultat);
    $id_assoc = $data[0];
    $id_acheteur = $data[1];

    
    $requete = "INSERT INTO paypal
                        SET
                        id_assoc = '$id_assoc',
			erreur = '$erreur',
                        paypal_email = '$receiver_email',
                        receiver_id = '$receiver_id',
                        id_objet = '$item_number',
                        montant = '$amount',
                        id_acheteur = '$id_acheteur',
                        payer_email = ' $payer_email',
                        txn_id = '$txn_id',
                        address_city = '$address_city',
                        address_country = '$address_country',
                        address_state = '$address_state',
                        address_country_code = '$address_country_code',
                        address_name = '$address_name',
                        address_status = '$address_status',
                        address_street = '$address_street',
                        address_zip = '$address_zip',
                        first_name = '$first_name',
                        last_name = '$last_name',
                        payer_business_name = '$payer_business_name',
                        payer_id = '$payer_id',
                        payer_status = '$payer_status',
                        residence_country = '$residence_country'                        
                        ";
    $resultat = mysql_query($requete);
    mysql_close();
    
    return $resultat;
    
    
}

// fonction envoi mail confirmation assoc

function envoyer_mail_assoc($item_number){
    	
//  récupération de l'adresse mail de l'assoc
    connex();
    $requete =  "SELECT spip_auteurs.email
                        FROM spip_encheres_objets,spip_articles,spip_rubriques,spip_auteurs
                        WHERE id_objet ='$item_number'
                        AND spip_encheres_objets.id_article = spip_articles.id_article
                        AND spip_articles.id_rubrique = spip_rubriques.id_rubrique
                        and spip_auteurs.id_auteur = spip_rubriques.id_auteur
                        LIMIT 1";
    $resultat = mysql_query($requete) or die("erreur mysql : " . mysql_error());
    $data = mysql_fetch_array($resultat);
    mysql_close();
    $email = $data[0];
        
        
        
    //$email = 'jean-pierre@y-media.be';
    $sujet = 'test mail paypal';
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

// ----------------  FONCTIONS DE VERIFICATION DES DONNEES DE LA TRANSACTION  ---------------------


// fonction de vérification si la transaction n'a pas encore été enregistrée

function VerifIXNID($txn_id){
    $conex = connex();
    $requete = "SELECT  txn_id FROM paypal WHERE txn_id =  '$txn_id' LIMIT 1";
    $resultat = mysql_query($requete);
    $data = mysql_fetch_array($resultat);
    mysql_close();
    if($data[0] ==''){
        return 0;
    }
    else{
        return 1;
    }
}

// fonction de vérification de l'adresse email paypal de l'association

function verif_business($item_number,$receiver_email){
    connex();
    $requete =  "SELECT spip_auteurs_elargis.paypal
                        FROM spip_encheres_objets,spip_articles,spip_rubriques,spip_auteurs_elargis
                        WHERE id_objet ='$item_number'
                        AND spip_encheres_objets.id_article = spip_articles.id_article
                        AND spip_articles.id_rubrique = spip_rubriques.id_rubrique
                        and spip_auteurs_elargis.id_auteur = spip_rubriques.id_auteur
                        LIMIT 1";
    $resultat = mysql_query($requete) or die("erreur mysql : " . mysql_error());
    $data = mysql_fetch_array($resultat);
    mysql_close();
    
    if($data[0] ==  $receiver_email)
        return 0;
    else
        return 1;
}

// fonction de vérification du montant payé chez paypal et du montant prix de l'objet

function verif_amount($item_number,$amount){
    connex();
    $requete = "SELECT montant_mise FROM spip_encheres_objets WHERE id_objet = '$item_number' LIMIT 1";
    $resultat = mysql_query($requete) or die("erreur mysql : " . mysql_error());
    $data = mysql_fetch_array($resultat);
    mysql_close();
    if($data[0] == $amount)
        return 0;
    else
        return 1;
}



// fonction de connexion à la db

function connex(){
    $conex = mysql_connect('localhost','kidonaki','vxKcQJzw6cxrgxx') or die("Impossible de se connecter : " . mysql_error());
    $db_conex = mysql_select_db('ki2naki') or die("Impossible de se connecter : " . mysql_error());
}



// ----------------  FONCTION DE MAIL SPIP SIMPLIFIEE  ---------------------



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
