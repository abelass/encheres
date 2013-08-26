<?php
if (!defined("_ECRIRE_INC_VERSION")) return;


function notifications_cloture_webmaster_dist($quoi,$id_encheres_objet, $options) {
    include_spip('inc/config');


    $envoyer_mail = charger_fonction('envoyer_mail','inc');
    
    $options['id_encheres_objet']=$id_encheres_objet; 
    $options['qui']='webmaster';  
    
    $email=isset($GLOBALS['meta']['facteur_adresse_envoi_email'])?$GLOBALS['meta']['facteur_adresse_envoi_email']:$GLOBALS['meta']['email_webmaster'];

    
    $subject=_T('encheres:encheres_cloture',array('titre'=>$titre));

    $message=recuperer_fond('notifications/contenu_cloture_mail',$options);
     
    //
    // Envoyer les emails
    //
    //
    //

    $envoyer_mail($email,$subject,array(
        'html'=>$message)
       );



}

?>