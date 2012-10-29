<?php

// This is a SPIP language file  --  Ceci est un fichier langue de SPIP nommé  genere le NOW()
// langue / language = en

$GLOBALS[$GLOBALS['idx_lang']] = array(

//	A		
'activer'	=>	"put on sale"	,
'ajouter_categorie'	=>	'add a category'	,
'ajouter_logo'	=>	"add a picture"	,
'aucune_enchere'	=>	"no auction for the moment"	,
			
//	B		
'telecharger_image'	=>	"download a picture"	,
			
			
//	C		
'categorie_liste'	=>	"chosen categories"	,
'categorie_objet_choisis'	=>	"chosen categories"	,
'champ_obligatoire'	=>	" compulsory field"	,
'choisir_categories'	=>	"choose category",
'choisir_projet'	=>	"choose a project"	,
'choisir_region'	=>	"choose your province"	,
'choisir_type_auteur'	=>	"choose your type"	,
'choix_projets1'	=>	"first project preference"	,
'choix_projets2'	=>	"second project preference"	,
'choix_projets3'	=>	"third project preference"	,
'cloture_enchere'	=>	"the auction ends within"	,
'compte_bancaire'	=>	" bank account number"	,
'confirmer'	=>	"confirm"	,
			
			
//	D		
'date_debut'	=>	"The auction is starting on"	,
'date_debut_court'	=>	"starting date"	,
'date_fin'	=>	"ending date"	,
'deja'	=>	"already"	,
'desactiver'	=>	" put in stand by"	,
'descriptif'	=>	"description"	,
'donnees_objets'	=>	"detailed description"	,
'duree'	=>	'Duration',
'duree_valide'	=>	"please mention a valid duration"	,
			
			
//	E		
'eliminer'	=>	"remove"	,
'email_asso_enchere_gagne_objet_message'	=>	'Good news! The item "@titre_article@ (@id_objet@)" has been sold in aid of your project "@titre_rubrique@" for an amount of @montant_mise@. 

Can we ask you to check your account @compte_bancaire_asso@ (@communication_virement@ - @titre_article@ - @id_objet@) and mention in your interface "My kidonaki" (@url_kidonateur@) that the payment has been effected (as soon as it has).

It\'s very important to have a quick and regular look at payments in order not to disturb the transaction between buyer and seller. This is necessary if you really want them to support you!',

'email_asso_enchere_gagne_sujet'	=>	"Item sold for your profit: payment to check"	,
'email_enchere_perdu_objet_message'	=>	'Unfortunately you haven\'t carried off the bid for the object "@titre_article@ (@id_objet@)" Don\'t hesitate to visit the site and display similar items @url_recherche@. 

Thank you for making purchases on Kidonaki.',
'email_enchere_perdu_sujet'	=>	"item which hasn't been taken away"	,
'email_encherisseur_enchere_reussi_objet_message'	=>	'Your bid for "@titre_article@ (@id_objet@)" has been registered and at the moment, you\'re the best bidder.

The auction ends on @date_fin@.

Thank you for making purchases on Kidonaki.'	,
'email_encherisseur_enchere_reussi_sujet'	=>	"successful auction"	,
'email_enchere_gagnee_message_paypal_asso'	=>	"The association also gives you the opportunity to effect your payment on its Paypal account"	,
'email_enchere_gagnee_message_paypal_kidonateur'	=>	"the kiddonor also gives you the opportunity to pay those costs via paypal : @url_paiement_objet@",
'email_encherisseur_surpasse_sujet'	=>	"surpassed auction"	,
'email_encherisseur_surpasse_objet_message'	=>	'Somebody has made a higher bid on the item "@titre_article@ (@id_objet@)". You are no longer the best bidder.

From now on, you can make a bid on @url_enchere@. Thanks to this purchase, you support the project @titre_rubrique@ conducted by @nom_asso@.

Thank you for making purchases on Kidonaki.',
'email_enchere_gagnee_message_specifique_venir'	=>	'
	- pay the amount of @montant_mise@ on the account @compte_bancaire_asso@ of @nom_asso@ Address: @adresse_asso@. Don\'t forget to mention the name and number of the item "@communication_virement@ - @titre_article@ - @id_objet@". 

	As soon as it has received the payment, the association "@nom_asso@" will warn the seller, who will get in touch with you for further arrangements.',
'email_enchere_gagnee_message_specifique_livraison'	=>	'
	- pay the amount of @montant_mise@ &euro; on the account @compte_bancaire_asso@ of @nom_asso@ Address: @adresse_asso@. Don\'t forget to mention "@communication_virement@ - @titre_article@ - @id_objet@". 
	
	As soon as it has received the payment,  @nom_asso@ will warn the seller, who will get in touch with you',
'email_enchere_gagnee_message_specifique_posteouvenir'	=>'
	- pay the amount of @montant_mise@ &euro; on the account @compte_bancaire_asso@ of @nom_asso@  - Address @adresse_asso@. Don\'t forget to mention @communication_virement@ - @titre_article@ - @id_objet@.@message_paypal_asso@ 
	
	As soon as it has received the payment, the @nom_asso@ will warn the seller to tell him he can deliver the item.
	
	- Pay the shipping costs OF @prix_transport@ &euro; on the account @compte_bancaire_asso@ de @nom_asso@ of the kidonor @nom_kidonateur@ 
	Don\'t forget to add "item shipping: @titre_article@ - @id_objet@" in the communication'	,
			
'email_enchere_gagnee_sujet'	=>	"sale closure: the item has been taken away."	,
'email_enchere_gagnee_objet_message'	=>	'Congratulations!  You have made the highest bid on "@titre_article@ (@id_objet@)". 
	
By buying this item, you support the project @titre_rubrique@  conducted by @nom_asso@. 
	
To get this item you must
	
@message_specifique@ 
	
Thank you for making purchases on Kidonaki. 
	
Be careful! This mail isn\'t a voucher. At this level, there\'s no evidence the credit transfer has been made on the association account.'	,
'email_mise_vente_objet_message'	=>	'We inform you that your item "@titre_article@ (@id_objet@)" has correctly been put on sale for a period of @duree_mise@ days, in aid of the project "@titre_rubrique@".@message_nombre@ 

If this item isn\'t bought within the determined period, you can click on "up for sale again", free of charge.

You\'ll receive an e-mail when the auction is closed.

@nom_asso@ and Kidonaki thank you warmly for your support.'	,
'email_kidonateur_enchere_gagnee_message_specifique_livraison'	=>	'The buyer has also been given instructions for the payment of shipping costs on your account.'	,
'email_kidonateur_enchere_gagnee_message_specifique_posteouvenir'	=>	"If he wants to pick up the item, he will get in touch with you by e-mail. "	,
'email_kidonateur_enchere_gagnee_message_specifique_venir'	=>	"You can e-mail the buyer to organize the taking-away of the item via his address	",
'email_kidonateur_enchere_gagnee_objet_message'	=>	'Congratulations! Your item "@titre_article@ (@id_objet@)" has been sold for @montant_mise@ EUR. 
	
This amount will be transferred by the buyer on the account of the association @nom_asso@ for the project @titre_rubrique@.
	
@message_specifique@

@nom_asso@ and Kidonaki thank you warmly for your support.',
'email_kidonateur_enchere_gagnee_sujet'	=>	"closed sale. Your item has been sold"	,
'email_kidonateur_enchere_sansmise_objet_message'	=>	'The item @titre_article@ (@id_objet@ you\'re selling in aid of the project @titre_rubrique@ hasn\'t found any purchaser. 

We invite you to put it on sale again,free of charge. Double-click via the following link: @url_kidonateur@

Of course you can change the data of the sale, by lowering the price f.i. But please, don\'t sell your item for a song. This is not supposed to be sold at a giveaway price, because your purpose is to support an association or a project. This item will probably please a buyer during the next auction session.

Thank you for your collaboration.'	,
'email_kidonateur_enchere_sansmise_sujet'	=>	"unsold item : put on sale again,free of charge"	,
'email_paiement_ok_acheteur_message_specifique_venir'	=>	"To get this item, you must now:

get in touch with the donor@prenom_kidonateur@  @nom_famille_kidonateur@, email: @email_kidonateur@",
'email_paiement_ok_acheteur_message_specifique_livraison'	=>	'To get this item, you still have to pay for shipping costs, which amount to @prix_livraison@ EUR on the account @compte_bancaire_kidonateur@ of the kidonor @prenom_kidonateur@ @nom_famille_kidonateur@.@message_paypal_kidonateur@',
'email_paiement_ok_acheteur_message'	=>	'The association @nom_asso@ confirms it has received payment for the item "@titre_article@ (@id_objet@)". 

If the shipping costs have also been settled or if there aren\'t any, you can deliver the item.

@message_specifique

Contact Kidonateur : @prenom_acheteur@ @nom_famille_acheteur@, @email_acheteur@

As soon as you have, don\'t forget to mention it in your "My Kidonaki" (@url_kido@) by ticking off a square "delivered item". We also invite you to give an indication of satisfaction for the buyer. 

Kidonaki and @nom_asso@ thank you for supporting the project @titre_rubrique@

Don\'t hesitate to return to the page of the project you have supported (@url_projet@) to ask questions or read possible news about this project.',
'email_paiement_ok_kidonateur_message_specifique_posteouvenir' => "The buyer has also received instructions for the transfer of the shipment costs to your account. 

If he wants to pick up personally the item, he will connect to you via email. ",
'email_paiement_ok_kidonateur_message_specifique_venir' => "Vous pouvez prendre contact avec l’acheteur par courriel pour organiser l’enlèvement de l’objet.",
'email_rappel_asso_message'	=>	'Obviously no transfer has been made so far on your account @compte_bancaire_asso@ by the buyer @prenom_acheteur@  @nom_famille_acheteur@ of the item @titre_article@  (@id_objet@) sold in aid of the project @titre_rubrique@ on the @date_vente@,

If , meanwhile, you have received your payment, let us know as soon as possible , so that we can release the transaction between the buyer and the seller.

Thanks in advance for your participation'	,
			
'email_paiement_ok_kidonateur_message'	=>	'The association @nom_asso@ confirms it has received payment for the item @titre_article@ (@id_objet@). 
	
If the shipping costs have also been settled or if there aren\'t any, you can deliver the item. 
	
@message_specifique@

Contact of the buyer : @prenom_acheteur@ @nom_famille_acheteur@ » : @email_acheteur@
	
As soon as you have, don\'t forget to mention it in your "My Kidonaki" (@url_kido@) by ticking off a square "delivered item". We also invite you to give an indication of satisfaction for the buyer. 

Kidonaki and @nom_asso@ thank you for supporting the project @titre_rubrique@

Don\'t hesitate to return to the page of the project you have supported (@url_projet@) to ask questions or read possible news about this project.',
'email_rappel_asso_message'	=>	'It seems that no transfer has been made so far on your account @compte_bancaire_asso@ by the buyer @prenom_acheteur@ @nom_famille_acheteur@ of the item @titre_article@ (@id_objet@) sold in aid of  the project "titre_rubrique@ ", on the @date_vente@. If meanwhile you have received  the payment, please let it know as soon as possible in your interface "My Kidonaki" so that the transaction between buyer and seller could be released.We thank you in advance for your participation.'	,
'email_rappel_asso_sujet'	=>	"Confirmation of delayed payment"	,
'email_rappel_acheteur_message'	=>	'The item @titre_article@ (@id_objet@) you bought on @date_vente@ hasn\'t been paid yet. We guess it\'s only forgetfulness. It\'s also possible the payment has just been made and the association hasn\'t had the time to confirm yet.

If you haven\'t paid yet, could you please do it as soon as possible. 

By buying this item, you support the project @titre_rubrique@ conducted by "@nom_asso@".

To get this item, you must now

@message_specifique@ 

We thank you for making purchases on Kidonaki.'	,
'email_rappel_acheteur_sujet'	=>	"bought item but delayed payment(first reminder)"	,
'email_rappel_2_acheteur_sujet'	=>	"bought item but delayed payment(second reminder)"	,
'email_rappel_3_acheteur_sujet'	=>	"bought item but delayed payment(third reminder)"	,
'email_rappel_vendeur_message'	=>	'Your item @titre_article@ (@id_objet@), sold on @date_vente@ in aid of project @titre_rubrique@ hasn\'t been paid yet. 

A reminder has been sent to the buyer and to the association @nom_asso@ so that the latter can check received payments.

As soon as @nom_asso@ confirms reception of payment, you\'ll be warned and it will be possible to give the item to the buyer @prenom_acheteur@ @nom_famille_acheteur@  - (@email_acheteur@), providing he has paid eventual shipping costs.

We thank you for your participation.'	,
'email_rappel_vendeur_sujet'	=>	"Sold item but delayed payment"	,
'email_signature'	=>	'Kidonaki. I new way to make a gift!'	,
'email_suiveur_avis_24_heures_objet_message'	=>	'The sale of the item "@titre_article@ (@id_objet@)" you have been watching or on which you have made a bid is about to end. If you are interested by this item, don\'t let it go! 

Thanks to this purchase, you\'ll support @titre_rubrique@. You can still make a higher bid on this item :@url_enchere@).'	,
'email_suiveur_avis_24_heures_sujet'	=>	"imminent sale closure. Don't wait"	,
'enchere_cloture'	=>	"The bidding is closed on"	,
'encheres'	=>	"Bidding"	,
'enregistrer'	=>	"enter"	,
'erreur_choisir_image'	=>	"Please, select a picture"	,
'erreur_saisie'	=> "Error"	,
'explicatif_ajouter_categorie'	=>	"Star-dotted categories are main categories and can't be selected"	,
'explicatif_montant_maximum'	=>	"(The system will automatically make bidding for you without exceeding this amount)"	,
'explicatif_prix'	=>	"minimum 5 €"	,
			
			
//	F		
'fin'	=>	"end"	,
'fin_enchere_non_termine'	=>	"bidding is not closed"	,
'fin_enchere_termine'	=>	'bidding closed'	,
'formats_autorises'	=>	"only png,gif pictures are allowed"	,
			
			
//	I		
'id_objet'	=>	"ID items"	,
'info_ong_marques'	=>	"Specific information from the association"	,
'infos_marques_asso'	=>	"Information related to the association"	,
'invendu'	=>	"Unsold"	,
			
			
//	L		
'livraison'	=>	"Delivery carried out"	,
'livraison_court'	=>	"delivery"	,
			
//	M		
'marque'	=>	"Brand/ commerce"	,
'mise_en_vente'	=>	"Putting up for sale"	,
'mise_en_vente_active'	=>	"Active putting up for sale"	,
'email_mise_vente_objet_sujet'	=>	"Confirmed putting up for sale"	,
'mode_livraison'	=>	"Mode of delivery"	,
'montant'	=>	'Amount'	,
'montant_trop_bas'	=>	"The minimum amount is @montant_min@ &euro;"	,
'montant_mise'	=>	"Amount"	,
'montant_mise_maximum'	=>	"maximum amount"	,
			
//	N		
'neuf'	=>	"new"	,
'nom_famille_personne_reponsable'	=>	'Family name of the person in charge'	,
'nom_marque'	=>	"Advertised name"	,
'nom_organisme'	=>	"Name of the association"	,
'nombre'	=>		'Number',
'nombre_valide'	=>	"Please, enter a valid number"	,
			
			
//	O		
'occasion'	=>	'second hand'	,
'objet'	=>	"item"	,
'ong'	=>	"Association/Non-governmental organisation"	,
			
			
//	P		
'particulier'	=>	"Private individual"	,
'paypal'	=>	"Paypal account"	,
'paypal_explications'	=>	"If you accept paypal payments, please give the e-mail address of your paypal account"	,
'personne_morale'	=>	"Moral person"	,
'personne_physique'	=>	"Physical person"	,
'poste'	=>	"Sent by post"	,
'posteouvenir'	=>	"Taking away at the seller's or post delivery"	,
'prenom_personne_reponsable'	=>	'Christian name of the person in charge'	,
'priorites'	=>	"Mention the projects you want to support"	,
'prix'	=>	"Price"	,
'prix_achat_inmediat'	=>	'"Direct sale" (fixed price paid by the buyer to the supported project)'	,
'prix_depart'	=>	"Auction( The start price is the minimum price )"	,
'prix_depart_expl'	=>	'Minimum amount paid by the buyer to the supported project'	,
'prix_livraison'	=>	"delivery costs"	,
'prix_livraison_expl'	=>	"(Amount paid by the buyer to the seller. Don't fill in if no delivery)"	,
'prix_maximum_trop_bas'	=>	"The maximum amount must be "	,
'prix_trop_bas'	=>	"Your amount is lower than 5 E. Please put on sale items the value of which is lower than 5 E."	,
'prix_valide'	=>	"Please, encode a figure only, without symbol"	,
'projet'	=>	"Project"	,
'projet_desactive'	=>	"The present-day project of this item has been deactivated.Please, chose another one."	,
			
//	R		
'region'	=>	"District"	,
			
			
//	S		
'section_vendeurs'	=>	"section sellers. (not necessary for buyers )"	,
'stand_by'	=>	"To put in stand-by"	,
'statut'	=>	"Status"	,
'statut_asso'	=>	"Status of the association"	,
'statut_juridque'	=>	"Legal status"	,
'supprime'	=>	"Deleted"	,
'supprimer'	=>	"To delete"	,
'supprimer_photo'	=>	"Delete the picture"	,
			
//	T		
'taille_document'	=>	"Maximum size : 3 meg."	,
'type'	=>	"State the item is in"	,
'type_auteur'	=>	"Registered as..."	,
'genre_prix'	=>	"Specify the kind of sale"	,
			
			
//	V		
'venir'	=>	"Taking away at the seller's"	,
'vente'	=>	"Sale"	,
'vente_directe'	=>	"This item is on direct sale"	,
'votre_mise'	=>	"Your bid"	,

// a partir du 26 08 09

'date_valide' => "Date format is not correct.  Please enter a valid date (YYYY-MM-DD HH:MM:SS)",
'marque_convention' => "Marque conventionnée",
'restaurant' => "Restaurant",

// a partir du 03 09 09 (done)

'courrier_velo' => 'Suggest to deliver the goods ecologically by bicycle (<a class=”nouvelle_fenetre”  href=”@url_art@” title="FAG - Dioxyde de Gambette" >Dioxyde de Gambettes</a>)',
'email_courrier_velo' => 'You want to receive the goods at home ? Just choose delivery by bicycle via Dioxyde de Gambette ! The Kidonator who sells this item is living in Brussels and suggests to use this ecological delivery opportunity.  If you choose to use it, the buyer will pay the delivery costs (standard delivery 5€) directly to the person delivering the goods. If you want to know more (@url_article@)',
'date_extistante' => "This date does not exist, please enter a valid date (YYYY-MM-DD)",
'option' => "Optional",
'date_debut' => "Change date to differ sale",
	
// 14 09 09

'email_paiement_ok_kidonateur_message_specifique_venir' => "The buyer has also received instructions for the transfer of the shipment costs to your account. 

// If he wants to pick up personally the item, he will connect to you via email",

// a partir du 10 09 09  (envoyé nl, en)
'email_kidonateur_rappel_vendeur_message' => "Notre système Kidonaki a constaté que vous aviez vendu l’objet « @titre_article@ (@id_objet@) » au profit du projet « @titre_rubrique@ ». L’association @nom_asso@ a confirmé avoir bien reçu le paiement de la part de l’acheteur @nom_acheteur@. 

Avez-vous un souci pour la livraison de l’objet ? Peut-être votre objet a-t-il été malgré tout envoyé au moment où ce mail de rappel vous parvient. 

Dans tous les cas, merci de tenir au courant l’acheteur en le contactant par email afin de le rassurer concernant ce retard.
 
Coordonnées mail de votre acheteur @nom_acheteur@ : @email_acheteur@ 
Nous vous remercions pour votre collaboration. ",
'email_kidonateur_rappel_vendeur_sujet' => "Votre objet est en attente de livraison",
'email_kidonateur_rappel_acheteur_recu_message' => "Notre système a constaté que votre achat « @titre_article@ (@id_objet@) » a été déclaré comme livré par le Kidonateur @prenom_kidonateur@ @nom_kidonateur@. 
 
Pour cette transaction, vous n’avez pas indiqué avoir reçu l’objet.  S’il s’agit d’un oubli de votre part, nous vous suggérons d’indiquer dans votre MON KIDONAKI (@url_kido@) que l’objet vous est parvenu, ce qui nous indique que la transaction a pu être menée avec succès jusqu’au bout.
 
Si , par contre,  vous n’avez toujours pas reçu l’objet, nous vous invitons à prendre contact avec le vendeur (Kidonateur). 
Coordonnées mail du Kidonateur :  @email_kidonateur@",
'email_kidonateur_rappel_acheteur_recu_sujet' => "Objet non-reçu ?",
'email_acheteur_paiement_livraison_ok_message' => "Par ce courriel, nous vous confirmons que  votre vendeur (kidonateur) a bien reçu le paiement des frais de transport pour l’objet « @titre_article@ (@id_objet@) » acheté sur Kidonaki  le @date_vente@. 
N’oubliez pas d’indiquer votre adresse (postale) de livraison au vendeur (kidonateur). 

Coordonnées Mail du Kidonateur : @email_kidonateur@

Vous devriez recevoir cet objet très prochainement

Nous vous remercions d’avoir soutenu le « @titre_rubrique@ »  grâce à cet achat.",
'email_kidonateur_rappel_acheteur_recu_sujet' => "Objet non-reçu ?",
'email_acheteur_paiement_livraison_ok_message' => "With this email, we confirm that your seller (kidonator) has indeed received the payment of the shipment costs for item  « @titre_article@ (@id_objet@) » purchased on Kidonaki  on @date_vente@. 

Please keep in mind to indicate your full postal delivery address to the seller (kidonator). 

Kidonator mail details : @email_kidonator@

The item should be delivered very soon.
                  
We thank you much to support « @titre_rubrique@ »  with this purchase.
 ",
'email_paiement_livraison_ok_sujet' => "Receipt payment for shipment costs",
'email_vendeur_paiement_livraison_ok_message' => "Shipment costs for item  « @titre_article@ (@id_objet@) » have indeed been transferred on your account by the buyer @prenom_acheteur@ @nom_famille_acheteur@. 

As soon as you are aware of the buyer postal address, you can ship the item. Your buyer has been notified, but you can as well ask him to send you his postal details via e-mail. 
Buyer email details : @email_acheteur@

We thank you again to support « @titre_rubrique@ »  with this purchase. ",
'message_specifique_nombre' => "You have put for sale @nombre@ copies of this item.  The system will put them for sale progressively starting with the first three copies ",

//à partir du 16/09 ajout par Jean-Pierre

'particuliers' => "Particuliers",
'restaurants' => "Restaurants",
'lieux' => "Partenaires culturels",
'marques' => "Kidonateurs professionnels",
'sponsors' => "Sponsors officiels",

//à partir du 18 09 Rainer
'email_objet_recu_kidonateur_message' => "L’acheteur @prenom_acheteur@ @nom_famille_acheteur@ a confirmé avoir bien reçu l’objet « @titre_article@ (@id_objet@) ».  

Grâce à cette vente,  vous avez soutenu le projet @titre_rubrique@ mené par  @nom_asso@ qui a donc reçu un don de @montant_mise@ €. 
Nous vous invitons à présent, si ce n’est pas encore fait, à laisser une évaluation pour cette transaction. 

Nous vous remercions pour votre collaboration et nous espérons que vous continuerez à soutenir des projets via Kidonaki.  N’hésitez pas  à également  utiliser le site pour effectuer vos achats ! ",
'email_objet_recu_kidonateur_sujet' => "Objet reçu par votre acheteur",
'email_remise_en_vente_vendeur_message' => "Nous constatons que l’acheteur @prenom_acheteur@ @nom_famille_acheteur@ n’a pas donné suite à son achat et n’a pas effectué le paiement de l’objet « @titre_article@ (@id_objet@) » sur le compte de l’association @nom_asso@. 
Le délai toléré ayant été dépassé, nous vous suggérons de :

 - Remettre simplement l’objet en vente  @url_remise@
 
Nous vous remercions d’utiliser Kidonaki pour soutenir le projet @titre_rubrique@. ",
'email_remise_en_vente_vendeur_sujet' => "Objet non-payé : remise en vente ?",
'remise_en_vente' => "Remise en vente",
'question_objet' => "Question sur votre objet @titre@ (répondre sur le site) ",
'reponse_objet' => "Réponse à votre question au sujet de  @titre@ (répondre sur le site) ",
'question_projet' => "Question sur votre projet @titre@ (répondre sur le site) ",
'reponse_projet' => "Réponse à votre question au sujet de  @titre@ (répondre sur le site) ",
'pas_repondre' => "ATTENTION: NE PAS REPONDRE A CE MAIL EN CLIQUANT SUR REPONDRE. (Merci d'utiliser uniquement les questions/réponses sur le site)",
'email_question_objet' => '@nom_question@ vous a posé une question au sujet de l\'objet @titre@

"@texte@"

Pour répondre à cette question, merci de visiter la page : @url@ 
et de cliquer sur "répondre au message" sous la question posée.

Vous aurez l\'occasion de publier ou non la question/réponse, selon votre choix.

Merci d\'avance 

L\'équipe de Kidonaki

ATTENTION: NE PAS REPONDRE A CE MAIL EN CLIQUANT SUR REPONDRE. (Merci d\'utiliser uniquement les questions/réponses sur le site) ',
'email_reponse_objet' => '@nom_reponse@ a répondu
 
"@reponse@" 
 
à votre question au sujet de l\'objet @titre@.

"@question@"

Si vous désirez continuer cette discussion en posant une autre question, merci de le faire en visitant cette page: @url@

ATTENTION: NE PAS REPONDRE A CE MAIL EN CLIQUANT SUR REPONDRE. (Merci d\'utiliser uniquement les questions/réponses sur le site)  ',
'email_question_projet' => '@nom_question@ vous a posé une question au sujet du projet @titre@

"@texte@"

Pour répondre à cette question, merci de visiter la page : @url@ 
et de cliquer sur "répondre au message" sous la question posée.

Vous aurez l\'occasion de publier ou non la question/réponse, selon votre choix.

Merci d\'avance 

L\'équipe de Kidonaki

ATTENTION: NE PAS REPONDRE A CE MAIL EN CLIQUANT SUR REPONDRE. (Merci d\'utiliser uniquement les questions/réponses sur le site) ',
'email_reponse_projet' => '@nom_reponse@ a répondu
 
"@reponse@" 
 
à votre question au sujet du projet @titre@.

"@question@"

Si vous désirez continuer cette discussion en posant une autre question, merci de le faire en visitant cette page: @url@

ATTENTION: NE PAS REPONDRE A CE MAIL EN CLIQUANT SUR REPONDRE. (Merci d\'utiliser uniquement les questions/réponses sur le site)  ',


// 28/09/09 ajout Jean-Pierre pour bulles info profil et auteur kidonateur

'k_gris' => "aucun objet vendu",
'k_bleu' => "Kidonateur actif",
'k_rouge' => "Kidonateur régulier",
'k_vert' => "Kidonateur confirmé",
'k_orange' => "Kidonateur assidu",
'k_super' => "SuperKidonateur",
'bulle_objet_vendu' => "objet vendu",
'bulle_objets_vendus' => "objets vendus",
'objet_envente' => "objet mis en vente",
'objets_envente' => "objets mis en vente",

'par_ce_kido' => "par ce Kinodateur",

'chiffreskido' => "Score Kidonateur",

);

?>