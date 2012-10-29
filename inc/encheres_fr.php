<?php

// This is a SPIP language file  --  Ceci est un fichier langue de SPIP nommé  genere le NOW()
// langue / language = fr

$GLOBALS[$GLOBALS['idx_lang']] = array(


// A
'activer' => 'Mettre en vente',
'ajouter_categorie' => 'Ajouter une catégorie',
'ajouter_logo' => 'Ajoutez une image',
'aucune_enchere' => 'Pas d\'enchère pour le moment',


// B
'bic' => 'BIC/SWIFT',
'bulle_objet_vendu' => 'objet vendu',
'bulle_objets_vendus' => 'objets vendus',


// C
'categorie_liste' => 'Les catégories choisies',
'categorie_objet_choisis' => 'Catégories choisies',
'champ_obligatoire' => 'Ce champ est obligatoire',
'chiffreskido' => 'Score Kidonateur',
'choisir_categories' => 'Choisissez les catégories',
'choisir_pays' => 'Votre pays',
'choisir_projet' => 'Choisissez le projet',
'choisir_region' => 'Choisissez votre',
'choisir_type_auteur' => 'Choisissez votre type',
'choix_projets1' => 'Première Préférence Projet',
'choix_projets2' => 'Deuxième Préférence Projet',
'choix_projets3' => 'Troisième Préférence Projet',
'cloture_enchere' => 'L\'enchère termine dans',
'compte_bancaire' => 'Nº IBAN',
'confirmer' => 'Confirmer',
'courrier_velo' => 'Suggérer la livraison écologique à bicyclette (<a class="nouvelle_fenetre" href="@url_art@" title="FAG - Dioxyde de Gambette">Dioxyde de Gambettes</a>)',


// D
'date_debut' => 'Changer la date pour différer la vente',
'date_debut_court' => 'Date début',
'date_extistante' => 'Cette date n\'existe pas, veuillez entre une date valide (YYYY-MM-DD)',
'date_fin' => 'Date fin',
'date_valide' => 'Le format de votre date n\'est pas correct, veuillez entre une date valide (YYYY-MM-DD HH:MM:SS)',
'deja' => 'Déjà',
'desactiver' => 'Mettre en stand by',
'descriptif' => 'Descriptif',
'donnees_objets' => 'Détails objets',
'duree' => 'Nombre de jours avant la clôture de la vente',
'duree_valide' => 'Veuillez mettre une durée valide',


// E
'eliminer' => 'Enlever',
'email_acheteur_paiement_livraison_ok_message' => 'Par ce courriel, nous vous confirmons que  votre vendeur (kidonateur) a bien reçu le paiement des frais de transport pour l’objet « @titre_article@ (@id_objet@) » acheté sur Kidonaki  le @date_vente@. 
N’oubliez pas d’indiquer votre adresse (postale) de livraison au vendeur (kidonateur). 

Coordonnées Mail du Kidonateur : @email_kidonateur@

Vous devriez recevoir cet objet très prochainement

Nous vous remercions d’avoir soutenu le « @titre_rubrique@ »  grâce à cet achat. ',
'email_asso_enchere_gagne_objet_message' => 'Bonne nouvelle ! L’objet « @titre_article@ (@id_objet@) » a été vendu au profit de votre projet « @titre_rubrique@ », pour un montant de « @montant_mise@ »€. 

Nous vous demandons de surveiller votre compte @compte_bancaire_asso@ (@communication_virement@ - @titre_article@ - @id_objet@) et de mentionner dans votre interface « Mon Kidonaki » (@url_kidonateur@) que le payement a été effectué( dès que c’est le cas).

Il est très important d’effectuer un suivi régulier et rapide des payements afin de ne pas perturber la transaction entre le vendeur (kidonateur) et l’acheteur. Cette condition est nécessaire pour les encourager à vous soutenir.

Nous vous remercions pour votre participation.',
'email_asso_enchere_gagne_sujet' => 'Objet vendu à votre profit : paiement à surveiller',
'email_avis_24_heures_remise_auto_message' => 'Votre objet « @titre_article@ (@id_objet@) » n\'a pour le moment aucune enchère et la période de vente se termine dans 24h.

Vous avez activé pour cet objet la fonction "remise en vente automatique". Si vous ne modifiez pas ce paramètre, dans votre espace personnel "Mon Kidonaki", votre objet sera remis en vente par le système, s\'il n\'a pas trouvé d\'acquéreur dans 24 heures.

Le système va conserver les caractéristiques de vente (durée, prix, projet soutenu, prix et mode de livraison, etc.). Assurez-vous donc que vous  possédez toujours l\'objet dans l\'état initial de la vente.

Le système remise en vente automatique vous permet ainsi de laisser des objets sur le site jusqu\'à ce qu\'il trouve un acquéreur. Désactivez cette fonction lorsque vous souhaitez retirer l\'objet du site. A la fin de la période actuelle de ventes, celui-ci ne sera donc plus disponible à l\'achat et sera repris dans la catégories "objets invendus".

Nous vous remercions de soutenir nos projets partenaires.',
'email_avis_24_heures_remise_auto_sujet' => 'Remise en vente automatique dans 24 heures',
'email_courrier_velo' => 'Vous désirez être livré chez vous ? Utilisez la bicyclette de Dioxyde de Gambette ! Le Kidonateur qui vend cet objet habite Bruxelles et vous suggère d’utiliser ce moyen de livraison écologique. Dans ce cas, l’acheteur paye les frais de livraison (livraison standard : 5€) directement au livreur. 

Le plus simple est donc de transmettre votre adresse et vos disponibilités pour la livraison au vendeur qui prendra contact avec le livreur cycliste. 

En savoir plus (@url_article@)',
'email_enchere_gagnee_message_paypal_asso' => 'L\'association vous propose également, si vous le désirez, d\' effectuer le paiement sur son compte Paypal : @url_paiement_objet@',
'email_enchere_gagnee_message_paypal_kidonateur' => 'Le Kidonateur vous propose également, si vous le désirez, de régler ces frais via paypal : @url_paiement_frais@',
'email_enchere_gagnee_message_specifique_email' => '- Payer le montant de @montant_mise@ € sur le compte @compte_bancaire_asso@ de @nom_asso@  - Adresse : @adresse_asso@. N’oubliez pas de mentionner « @communication_virement@ - @titre_article@ - @id_objet@ » en communication.

	Dès qu’elle aura reçu le paiement, l\'association « @nom_asso@ » avertira le Kidonateur (vendeur) pour lui dire de se mettre en contact avec vous afin de régler les détails concernant l\'enlèvement de l\'objet.@message_paypal_asso@

Votre objet acheté est une place/entrée de la billetterie solidaire de KIDONAKI. Nous vous invitons à faire le virement (payement) sur le compte de l\'association au plus vite, afin de profiter d\'un maximum de jours de validité.

Rappel: la période de validité pour ce billet: du @date_debut@ au @date_fin@',
'email_enchere_gagnee_message_specifique_livraison' => '	- Payer le montant de @montant_mise@ € sur le compte @compte_bancaire_asso@ de @nom_asso@  - Adresse : @adresse_asso@. N’oubliez pas de mentionner «@communication_virement@ - @titre_article@ - @id_objet@ » en communication.@message_paypal_asso@

	Dès qu’elle aura reçu le paiement, @nom_asso@ avertira le Kidonateur pour lui dire qu’il peut vous délivrer l’objet. 

	- Payer les frais de transport qui s’élèvent à @prix_transport@ € sur le compte @compte_bancaire_kidonateur@ du kidonateur @nom_kidonateur@.  N’oubliez pas de préciser  « transport objet: @titre_article@ - @id_objet@ »  en communication.@message_paypal_kidonateur@ ',
'email_enchere_gagnee_message_specifique_posteouvenir' => '	- Payer le montant de @montant_mise@ € sur le compte @compte_bancaire_asso@ de @nom_asso@  - Adresse : @adresse_asso@. N’oubliez pas de mentionner «@communication_virement@ - @titre_article@ - @id_objet@ » en communication.@message_paypal_asso@

	Dès qu’elle aura reçu le paiement, @nom_asso@ avertira le Kidonateur pour lui dire qu’il peut vous délivrer l’objet. 

	- Payer les frais de transport (dans le cas où vous ne souhaitez pas enlever l’objet chez le Kidonateur) qui s’élèvent à @prix_transport@ € sur le compte @compte_bancaire_kidonateur@ du kidonateur @nom_kidonateur@.  N’oubliez pas de préciser  «  transport: @id_objet@ » (numéro de l’objet) en communication.@message_paypal_kidonateur@ ',
'email_enchere_gagnee_message_specifique_venir' => '	- Payer le montant de @montant_mise@ € sur le compte @compte_bancaire_asso@ de @nom_asso@  - Adresse : @adresse_asso@. N’oubliez pas de mentionner « @communication_virement@ - @titre_article@ - @id_objet@ » en communication.

	Dès qu’elle aura reçu le paiement, l\'association « @nom_asso@ » avertira le Kidonateur (vendeur) pour lui dire de se mettre en contact avec vous afin de régler les détails concernant l\'enlèvement de l\'objet.@message_paypal_asso@',
'email_enchere_gagnee_objet_message' => 'Félicitations ! Vous avez remporté l\'enchère pour « @titre_article@ (@id_objet@) ». 

En achetant cet objet, vous soutenez le projet « @titre_rubrique@ » mené par « @nom_asso@ ». 

Pour obtenir cet objet, vous devez à présent : 

@message_specifique@

Nous vous remercions de faire vos achats sur le site Kidonaki.

ATTENTION, ce mail n’est pas un bon d’achat.  

A ce stade, rien ne certifie que le virement a été effectué au profit de l’association. ',
'email_enchere_gagnee_sujet' => 'Vente clôturée : objet remporté !',
'email_enchere_perdu_objet_message' => 'Malheureusement vous n’avez pas remporté l’enchère pour l’objet « @titre_article@ (@id_objet@) ». 
 
N’hésitez pas à visiter notre site et afficher les objets similaires : @url_recherche@.

Nous vous remercions de faire vos achats sur le site Kidonaki. ',
'email_enchere_perdu_sujet' => 'Objet non-remporté',
'email_encherisseur_enchere_reussi_objet_message' => 'Votre enchère pour « @titre_article@ (@id_objet@) » a bien été enregistrée et vous êtes actuellement le meilleur enchérisseur. 

L\'enchère sera cloturée le @date_fin@. 

Grâce à cet achat, vous soutenez le projet « @titre_rubrique@ ». 

Nous vous remercions de faire vos achats sur le site Kidonaki.',
'email_encherisseur_enchere_reussi_sujet' => 'Enchère réussie',
'email_encherisseur_surpasse_objet_message' => 'Quelqu’un a surenchéri sur l’objet « @titre_article@ (@id_objet@) »  et vous n’êtes actuellement plus le meilleur enchérisseur. 

Vous pouvez enchérir sur cet objet dès maintenant: @url_enchere@

Grâce à cet achat, vous soutiendriez le projet @titre_rubrique@ mené par @nom_asso@.

Nous vous remercions de faire vos achats sur le site Kidonaki.',
'email_encherisseur_surpasse_sujet' => 'Enchère surpassée',
'email_kidonateur_enchere_gagnee_message_specifique_livraison' => 'L’acheteur a également reçu les instructions pour le payement des frais de transport sur votre compte.',
'email_kidonateur_enchere_gagnee_message_specifique_posteouvenir' => 'L’acheteur a également reçu les instructions pour le payement des frais de transport sur votre compte.  

S’il désire venir chercher l’objet, il prendra  contact avec vous par courriel.',
'email_kidonateur_enchere_gagnee_message_specifique_venir' => 'Vous pourrez prendre contact avec l’acheteur par courriel pour organiser l’enlèvement de l’objet. 

Voici les coordonnées mail de l’acheteur @prenom@  @nom_famille@ pour tout souci ou remarque : @email@',
'email_kidonateur_enchere_gagnee_objet_message' => 'Félicitations, votre objet « @titre_article@ (@id_objet@) » a été vendu pour un montant de @montant_mise@ € !

Ce montant sera versé par l’acheteur à l’association @nom_asso@ pour le projet @titre_rubrique@

@message_specifique@

Kidonaki et « @nom_asso@ » vous remercient  d’avoir soutenu le projet @titre_rubrique@.',
'email_kidonateur_enchere_gagnee_sujet' => 'Vente clôturée : Votre objet est vendu !',
'email_kidonateur_enchere_sansmise_objet_message' => 'Votre objet « @titre_article@ (@id_objet@) », que vous vendez au profit du projet @titre_rubrique@, n’a pas trouvé d’acquéreur. 

Nous vous invitons à le remettre en vente gratuitement, en deux clics, via le lien ci-dessous. 

Vous pouvez bien entendu changer les caractéristiques de la vente, et par exemple baisser le prix. Mais ne bradez pas vos objets ! Ce n’est pas parce qu’ils sont vendus au profit d’une association ou d’une cause qu’ils ne doivent pas être vendus  au prix « du marché ».
Votre objet fera certainement  le bonheur d’un acheteur lors de la prochaine session d’enchères. 

Nous vous remercions pour votre collaboration. 

Lien de remise en vente: @url_kidonateur@',
'email_kidonateur_enchere_sansmise_sujet' => 'Objet invendu : remettez en vente gratuitement',
'email_kidonateur_rappel_acheteur_recu_message' => 'Notre système a constaté que votre achat « @titre_article@ (@id_objet@) » a été déclaré comme livré par le Kidonateur @prenom_kidonateur@ @nom_kidonateur@. 
 
Pour cette transaction, vous n’avez pas indiqué avoir reçu l’objet.  S’il s’agit d’un oubli de votre part, nous vous suggérons d’indiquer dans votre MON KIDONAKI (@url_kido@) que l’objet vous est parvenu, ce qui nous indique que la transaction a pu être menée avec succès jusqu’au bout.
 
Si , par contre,  vous n’avez toujours pas reçu l’objet, nous vous invitons à prendre contact avec le vendeur (Kidonateur). 
Coordonnées mail du Kidonateur :  @email_kidonateur@',
'email_kidonateur_rappel_acheteur_recu_sujet' => 'Objet non-reçu ?',
'email_kidonateur_rappel_vendeur_message' => 'Notre système Kidonaki a constaté que vous aviez vendu l’objet « @titre_article@ (@id_objet@) » au profit du projet « @titre_rubrique@ ». L’association @nom_asso@ a confirmé avoir bien reçu le paiement de la part de l’acheteur @nom_acheteur@. 

Avez-vous un souci pour la livraison de l’objet ? Peut-être votre objet a-t-il été malgré tout envoyé au moment où ce mail de rappel vous parvient. 

Dans tous les cas, merci de tenir au courant l’acheteur en le contactant par email afin de le rassurer concernant ce retard.
 
Coordonnées mail de votre acheteur @nom_acheteur@ : @email_acheteur@ 
Nous vous remercions pour votre collaboration. ',
'email_kidonateur_rappel_vendeur_sujet' => 'Votre objet est en attente de livraison',
'email_mise_vente_objet_message' => 'Nous vous confirmons que votre objet « @titre_article@ (@id_objet@) » a été correctement mis en vente pour une période de @duree_mise@ jours, au profit du projet « @titre_rubrique@ ».@message_nombre@ 

Si cet objet n’a pas trouvé d’acquéreur endéans la période choisie, vous pourrez cliquer sur «remettre en vente», sans aucun frais bien entendu. 

Vous recevrez un mail lors de la clôture de l’enchère. 

@nom_asso@ et Kidonaki vous remercient chaleureusement pour votre soutien.',
'email_mise_vente_objet_sujet' => 'Mise en vente confirmée',
'email_objet_recu_kidonateur_message' => 'L’acheteur @prenom_acheteur@ @nom_famille_acheteur@ a confirmé avoir bien reçu l’objet « @titre_article@ (@id_objet@) ».  

Grâce à cette vente,  vous avez soutenu le projet @titre_rubrique@ mené par  @nom_asso@ qui a donc reçu un don de @montant_mise@ €. 
Nous vous invitons à présent, si ce n’est pas encore fait, à laisser une évaluation pour cette transaction. 

Nous vous remercions pour votre collaboration et nous espérons que vous continuerez à soutenir des projets via Kidonaki.  N’hésitez pas  à également  utiliser le site pour effectuer vos achats ! ',
'email_objet_recu_kidonateur_sujet' => 'Objet reçu par votre acheteur',
'email_paiement_livraison_ok_sujet' => 'Réception paiement pour Frais de Transports',
'email_paiement_ok_acheteur_message' => 'Votre virement sur le compte de l’association « @nom_asso@ » pour l’objet « @titre_article@ (@id_objet@) » a bien été validé. 

@message_specifique@',
'email_paiement_ok_acheteur_message_specifique_email' => 'Ce mail fait office de bon à valoir pour votre achat. Vous devez donc l\'imprimer, sauf si les conditions énoncées dans la description fixaient une autre procédure.

Rappel des conditions émises par l\'organisme vendeur: "@commentaire@" ',
'email_paiement_ok_acheteur_message_specifique_livraison' => 'Pour obtenir cet objet, vous devez à présent (si ce n’est pas encore fait): 

Payer les frais transport qui s’élèvent à « @prix_livraison@ »€ sur le compte @compte_bancaire_kidonateur@ du kidonateur @prenom_kidonateur@ @nom_famille_kidonateur@.@message_paypal_kidonateur@',
'email_paiement_ok_acheteur_message_specifique_posteouvenir' => 'Pour obtenir cet objet, vous devez à présent (si ce n’est pas encore fait): 

Payer les frais de transports (dans le cas où vous ne souhaitez pas enlever l’objet chez le Kidonateur)  qui s’élèvent à « @prix_livraison@ »€ sur le compte @compte_bancaire_kidonateur@ du kidonateur @prenom_kidonateur@ @nom_famille_kidonateur@ + @adresse_kidonateur@, @code_postale_kidonateur@ @ville_kidonateur@.@message_paypal_kidonateur@

Si vous désirez enlever l’objet sur place (@ville_kidonateur@), vous pouvez d’ores et déjà le signaler au Kidonateur en le contactant :@email_kidonateur@ du kidonateur. ',
'email_paiement_ok_acheteur_message_specifique_venir' => 'Pour obtenir cet objet, vous devez à présent : 

Prendre contact avec le Kidonateur « @prenom_kidonateur@  @nom_famille_kidonateur@ » pour organiser l’enlèvement de l’objet.

Coordonnées mail du Kidonateur : @email_kidonateur@.',
'email_paiement_ok_acheteur_sujet' => 'Votre paiement validé',
'email_paiement_ok_kidonateur_message' => 'L\'association « @nom_asso@ » confirme avoir reçu le payement pour l\'objet « @titre_article@ (@id_objet@) ». 

Si vos frais de transport ont également été réglés ou s\'il n\'y en a pas, vous pouvez donc délivrer l\'objet à l\'acheteur. 

@message_specifique@

Coordonnées de l\'acheteur « @prenom_acheteur@ @nom_famille_acheteur@ » : @email_acheteur@

Dès que vous avez délivré l\'objet, n\'oubliez pas de le mentionner dans votre espace personnel « Mon Kidonaki »(@url_kido@), en cochant la case « Objet livré ». Nous vous invitons également à laisser un indice de satisfaction pour l\'acheteur. 

Kidonaki et « @nom_asso@ » vous remercient  d\'avoir soutenu le projet @titre_rubrique@. 

N\'hésitez pas à vous rendre sur la page du projet que vous avez soutenu (@url_projet@) pour poser des questions ou lire les éventuelles nouvelles du projet.',
'email_paiement_ok_kidonateur_message_specifique_email' => 'Sauf contre-indication préalable (dans la description de l\'annonce) de votre part, l\'acheteur imprimera ce mail qui fera office de bon à valoir.',
'email_paiement_ok_kidonateur_message_specifique_livraison' => 'L’acheteur a également reçu les instructions pour le payement des frais de transport sur votre compte.  Si ceux-ci ne sont pas encore réglés, n’hésitez pas à prendre contact avec lui par email.',
'email_paiement_ok_kidonateur_message_specifique_posteouvenir' => 'L’acheteur a également reçu les instructions pour le payement des frais de transport sur votre compte. 

S’il désire venir chercher l’objet, il prendra  contact avec vous par courriel. ',
'email_paiement_ok_kidonateur_message_specifique_venir' => 'Vous pouvez prendre contact avec l’acheteur par courriel pour organiser l’enlèvement de l’objet.',
'email_paiement_ok_kidonateur_sujet' => 'Objet vendu payé',
'email_question_objet' => '@nom_question@ vous a posé une question au sujet de l\'objet @titre@

"@texte@"

Pour répondre à cette question, merci de visiter la page : @url@ 
et de cliquer sur "répondre au message" sous la question posée.

Vous aurez l\'occasion de publier ou non la question/réponse, selon votre choix.

Merci d\'avance 

L\'équipe de Kidonaki

ATTENTION: NE PAS REPONDRE A CE MAIL EN CLIQUANT SUR REPONDRE. (Merci d\'utiliser uniquement les questions/réponses sur le site) ',
'email_question_projet' => '@nom_question@ vous a posé une question au sujet du projet @titre@

"@texte@"

Pour répondre à cette question, merci de visiter la page : @url@ 
et de cliquer sur "répondre au message" sous la question posée.

Vous aurez l\'occasion de publier ou non la question/réponse, selon votre choix.

Merci d\'avance 

L\'équipe de Kidonaki

ATTENTION: NE PAS REPONDRE A CE MAIL EN CLIQUANT SUR REPONDRE. (Merci d\'utiliser uniquement les questions/réponses sur le site) ',
'email_rappel_2_acheteur_sujet' => 'Objet acheté en attente de payement (deuxième rappel)',
'email_rappel_3_acheteur_sujet' => 'Objet acheté en attente de payement (troisième rappel)',
'email_rappel_acheteur_message' => 'L’objet @titre_article@ (@id_objet@) que vous avez remporté le @date_vente@ n’aurait pas encore été payé.  Nous imaginons  qu’il s’agit d’un oubli de votre part ou que le payement vient d’être effectué et que l’association n’a pas encore eu le temps de le confirmer. 

Si vous n’avez pas encore fait le versement, nous vous remercions de bien vouloir régulariser cette situation.

En achetant cet objet, vous soutenez le projet « @titre_rubrique@ mené par « @nom_asso@ ». 

Pour obtenir cet objet, vous devez à présent : 

@message_specifique@

Nous vous remercions de faire vos achats sur le site Kidonaki.',
'email_rappel_acheteur_sujet' => 'Objet acheté en attente de payement (rappel)',
'email_rappel_asso_message' => 'L’objet « @titre_article@ (@id_objet@)  » qui a été vendu au profit du projet « @titre_rubrique@ »  le @date_vente@ n’a visiblement pas encore fait l’objet d’un virement sur votre compte @compte_bancaire_asso@, par l’acheteur @prenom_acheteur@ @nom_famille_acheteur@.
 
Si vous aviez entretemps reçu le payement,  nous vous remercions de bien vouloir le signaler au plus vite dans votre interface « Mon Kidonaki » afin de débloquer la transaction entre l’acheteur et le vendeur.  

D’avance, merci pour votre participation',
'email_rappel_asso_sujet' => 'Confirmation de versement en attente',
'email_rappel_vendeur_message' => 'Votre objet « @titre_article@ (@id_objet@) » vendu le @date_vente@ au profit du projet « @titre_rubrique@ » est en attente de paiement. 

Un rappel a été envoyé à l’acheteur et à l’association « @nom_asso@ » pour qu’elle vérifie les paiements reçus. 

Dès que « @nom_asso@ » confirme la réception du payement, vous en serez averti et vous pourrez délivrer l’objet à l’acheteur « @prenom_acheteur@ @nom_famille_acheteur@ »(@email_acheteur@), à condition également que les éventuels frais de transport vous ait été  payés par celui-ci. 

Nous vous remercions encore pour votre participation. ',
'email_rappel_vendeur_sujet' => 'Objet vendu en attente de payement',
'email_remise_en_vente_sans_payer_encherisseurs_message' => 'Vous aviez placé une enchère sur l’objet @titre_article@ (@id_objet@), qui avait finalement été remportée par @prenom_acheteur@ @nom_famille_acheteur@  le @date_vente@. 

Cette vente ne s’est pas clôturée et @nom_kidonateur@ @nom_famille_kidonateur@ a décidé de remettre son objet en vente. 
 
Nous vous invitons donc à enchérir à nouveau sur cet objet si celui-ci vous intéresse toujours : @url_enchere@. 

Nous vous remercions d’utiliser Kidonaki pour vos achats . ',
'email_remise_en_vente_sans_payer_encherisseurs_sujet' => 'Objet  @titre_article@ (@id_objet@) à nouveau disponible',
'email_remise_en_vente_vendeur_message' => 'Nous constatons que l’acheteur @prenom_acheteur@ @nom_famille_acheteur@ n’a pas donné suite à son achat et n’a pas effectué le paiement de l’objet « @titre_article@ (@id_objet@) » sur le compte de l’association @nom_asso@. 
Le délai toléré ayant été dépassé, nous vous suggérons de :

 - Remettre simplement l’objet en vente  @url_remise@
 
Nous vous remercions d’utiliser Kidonaki pour soutenir le projet @titre_rubrique@. ',
'email_remise_en_vente_vendeur_sujet' => 'Objet non-payé : remise en vente ?',
'email_reponse_objet' => '@nom_reponse@ a répondu
 
"@reponse@" 
 
à votre question au sujet de l\'objet @titre@.

"@question@"

Si vous désirez continuer cette discussion en posant une autre question, merci de le faire en visitant cette page: @url@

ATTENTION: NE PAS REPONDRE A CE MAIL EN CLIQUANT SUR REPONDRE. (Merci d\'utiliser uniquement les questions/réponses sur le site)  ',
'email_reponse_projet' => '@nom_reponse@ a répondu
 
"@reponse@" 
 
à votre question au sujet du projet @titre@.

"@question@"

Si vous désirez continuer cette discussion en posant une autre question, merci de le faire en visitant cette page: @url@

ATTENTION: NE PAS REPONDRE A CE MAIL EN CLIQUANT SUR REPONDRE. (Merci d\'utiliser uniquement les questions/réponses sur le site)  ',
'email_signature' => 'L\'équipe de Kidonaki

Kidonaki - Une manière inédite de faire un don !',
'email_suiveur_avis_24_heures_objet_message' => 'La vente de l\'objet « @titre_article@ (@id_objet@) » que vous suiviez ou sur lequel vous aviez porté une enchère est en passe de e clôturer. Si cet objet vous intéresse ne le laisser pas filer !


         Grâce à cet achat, vous soutiendriez le projet « @titre_rubrique@ » mené par « @nom_asso@ ».


Vous pouvez encore enchérir sur cet objet dès maintenant : @url_enchere@)',
'email_suiveur_avis_24_heures_sujet' => 'Fin de vente imminente : n’attendez plus !',
'email_vendeur_paiement_livraison_ok_message' => 'Les frais de transport pour l’objet « @titre_article@ (@id_objet@) » ont bien été versés sur votre compte par l’acheteur @prenom_acheteur@ @nom_famille_acheteur@. 

Dès que vous aurez connaissance de l’adresse postale de l’acheteur, vous pouvez délivrer l’objet.  Votre acheteur est prévenu, mais vous pouvez aussi lui demander de vos envoyer ses coordonnées postales par courriel. 

Coordonnées Mail de l’acheteur : @email_acheteur@

Nous vous remercions encore d’avoir soutenu le « @titre_rubrique@ »  grâce à cette vente. ',
'enchere_cloture' => 'Enchère clôturée le',
'encheres' => 'enchères',
'encheres_auto' => '(enchères automatiques)',
'encheres_maj' => 'Enchères',
'enregistrer' => 'Enregistrer',
'erreur_choisir_image' => 'Veuillez sélectionner une image !',
'erreur_saisie' => 'Votre saisie contient des erreurs !',
'explicatif_ajouter_categorie' => '* Les catégories avec étoiles sont des catégories principales et donc pas sélectionables.',
'explicatif_montant_maximum' => '(Le système fera automatiquement des enchères pour vous, sans jamais dépasser ce montant)',
'explicatif_prix' => 'Minimum 5€',
'explication_remise_vente_automatique' => 'L\'objet sera remis en vente automatiquement la la fin de la période de vente!',


// F
'fin' => 'Fin',
'fin_enchere_non_termine' => 'Fin enchère non cloturée',
'fin_enchere_termine' => 'Fin enchère cloturée',
'fisc' => 'Déduction Fiscal',
'formats_autorises' => 'Seules des images en format png,jpg,gif sont autorisés',


// G
'genre_prix' => 'Précisez le type de vente',


// I
'id_objet' => 'ID OBJET',
'info_ong_marques' => 'Info spécifique de l\'Organisme',
'infos_marques_asso ' => 'Information sur l\'Organisme',
'invendu' => 'Invendu',


// K
'k_bleu' => 'Kidonateur actif',
'k_gris' => 'aucun objet vendu',
'k_orange' => 'Kidonateur assidu',
'k_rouge' => 'Kidonateur régulier',
'k_super' => 'SuperKidonateur',
'k_vert' => 'Kidonateur confirmé',


// L
'lieux' => 'Partenaires culturels',
'livraison' => 'Livraison à domicile (chez l’acheteur)',
'livraison_court' => 'Livraison',
'livraison_email' => 'Envoi par email',
'livraison_etranger' => 'J\'accepte de livrer dans un autre pays',


// M
'marque' => 'Marque/commerce',
'marque_convention' => 'Marque conventionnée',
'marques' => 'Kidonateurs professionnels',
'message_erreur_livraison_0' => 'Attention, en indiquant 0, vous vous engagez à livrer votre objet par la poste à vos frais!',
'message_specifique_nombre' => 'Vous avez mis en vente @nombre@ exemplaires de cet objet. Le système les mettra en vente au fur et à mesure, en commençant par trois exemplaires. ',
'mise_en_vente' => 'Mise en vente',
'mise_en_vente_active' => 'Mise en vente actif',
'mode_livraison' => 'Mode livraison',


// 0
'0' => 'Mise en vente confirmée',


// M
'montant' => 'Montant',
'montant_mise' => 'Montant',
'montant_mise_maximum' => 'Montant maximum',
'montant_trop_bas' => 'Le montant minimum est de @montant_min@ €!',


// N
'neuf' => 'Neuf',
'nom_famille_personne_reponsable' => 'Nom de famille du repsonable',
'nom_marque' => 'Nom affiché pour le public (nom de la marque)',
'nom_organisme' => 'Nom de l\'organisme',
'nombre' => 'Nombre d’exemplaires de l’objet',
'nombre_expl' => 'Le système mettra automatiquement en vente les exemplaires de l\'objet, au fur et à mesure, trois par trois',
'nombre_valide' => 'Veuillez mettre un nombre valide',


// O
'objet' => 'Objet',
'objet_envente' => 'objet mis en vente',
'objets_envente' => 'objets mis en vente',
'occasion' => 'Occasion',
'ong' => 'Association/ONG',
'option' => 'En option',
'oui' => 'Oui',


// P
'par_ce_kido' => 'par ce Kinodateur',
'particulier' => 'Particulier',
'particuliers' => 'Particuliers',
'pas_repondre' => 'ATTENTION: NE PAS REPONDRE A CE MAIL EN CLIQUANT SUR REPONDRE. (Merci d\'utiliser uniquement les questions/réponses sur le site)',
'paypal' => 'Compte Paypal',
'paypal_explications' => 'Facultatif: si vous acceptez des paiements par paypal, veuillez indiquer votre adresse email de votre compte paypal',
'personne_morale' => 'Personne morale',
'personne_physique' => 'Personne physique',
'poste' => 'Envoi par la poste',
'posteouvenir' => 'Enlèvement auprès du vendeur ou envoi par poste',
'prenom_personne_reponsable' => 'Prénom du responsable',
'priorites' => 'Indiquez les projets que vous aimez soutenir',
'prix' => 'Prix',
'prix_achat_inmediat' => 'Vente directe (Prix fixe versé par l’acheteur au projet soutenu)',
'prix_depart' => 'Vente aux enchères <br/><small>(Le prix est un prix de départ, minimum versé par l’acheteur au projet soutenu)</small>',
'prix_depart_expl' => 'Montant minimum versé par l\'acheteur au projet soutenu',
'prix_livraison' => 'Prix livraison',
'prix_livraison_etrange' => 'Prix livraison étranger',
'prix_livraison_etranger_expl' => 'Pour les pays européens',
'prix_livraison_expl' => '(Montant payé par l\'acheteur au vendeur, laissez vide si pas de livraison)<br/>Montant sans décimales',
'prix_maximum_trop_bas' => 'le montant maximun doit être de @prix_max_min@ € au minimum',
'prix_trop_bas' => 'Votre montant est inférieur à 5€. Nous vous demandons de mettre en vente des objets dont la valeur réelle est minimum 5€.',
'prix_valide' => 'Merci d\'encoder uniquement un chiffre, sans symbole ni décimale',
'projet' => 'Projet',
'projet_desactive' => 'Le projet actuel de cet objet a été désactivé, veuillez choisir un autre',


// Q
'question_objet' => 'Question sur votre objet @titre@ (répondre sur le site) ',
'question_projet' => 'Question sur votre projet @titre@ (répondre sur le site) ',


// R
'region' => 'Région',
'remise_en_vente' => 'Remise en vente',
'remise_vente_automatique' => 'Remise en vente automatique',
'reponse_objet' => 'Réponse à votre question au sujet de  @titre@ (répondre sur le site) ',
'reponse_projet' => 'Réponse à votre question au sujet de  @titre@ (répondre sur le site) ',
'restaurant' => 'Restaurant',
'restaurants' => 'Restaurants',


// S
'section_vendeurs' => 'Section vendeurs <br/> <small> (pas nécessaire pour les seuls acheteurs)</small>',
'sponsors' => 'Sponsors officiels',
'stand_by' => 'Mettre en Stand By',
'statut' => 'Statut',
'statut_asso' => 'Statut Organisme',
'statut_juridque' => 'Statut juridique',
'supprime' => 'Supprimé',
'supprimer' => 'Supprimer',
'supprimer_photo' => 'Supprimer l\'image',


// T
'taille_document' => 'Taille maximale : 3 Megas!',
'telecharger_image' => 'Télécharger une photo depuis votre ordinateur ',
'type' => 'Etat de l’objet',
'type_auteur' => 'Inscription en tant que :',


// V
'venir' => 'Enlèvement auprès du vendeur',
'vente' => 'Vente',
'vente_directe' => 'Cet objet est en vente directe',
'votre_mise' => 'Votre mise'


);

?>