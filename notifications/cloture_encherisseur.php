<?php
if (!defined("_ECRIRE_INC_VERSION")) return;


function notifications_cloture_encherisseur_dist($quoi,$id_encheres_objet, $options) {
    include_spip('inc/config');
    $config = lire_config('reservation_evenement');
    spip_log($options,'teste');
    $envoyer_mail = charger_fonction('envoyer_mail','inc');
    
    $options['id_encheres_objet']=$id_encheres_objet;  
    $options['qui']='encherisseur';     
    $subject=_T('encheres:sujet_votre_enchere_gagne_sur',array('nom'=>$GLOBALS['meta']['nom_site']));

    $message=recuperer_fond('notifications/contenu_cloture_mail',$options);
     
    //
    // Envoyer les emails
    //
    //
    //


   $o=array(
        'html'=>$message,
        );


    $envoyer_mail($options['email'],$subject,$o);
}

?>