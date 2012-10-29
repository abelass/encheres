<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_logo_breve_charger_dist($id_breve,$logo=''){
	$valeurs = array('id_breve'=>$id_breve,'logo'=>$logo);

	return $valeurs;
};



/* @annotation: Validation des champs obligatoires */
function formulaires_logo_breve_verifier_dist($id_breve,$logo=''){
	$erreurs = array();
	/* @annotation: le champ prix_livraison est obligatoire si la marchandise est livré ou envoyé ou les deux, si pas de frais de livraison exigé, on permet la valeur 0*/

$filename = $_FILES["file"]["name"];
$file_basename = substr($filename, 0, strripos($filename, '.')); // strip extention
$file_ext = substr($filename, strripos($filename, '.')); // strip name
$filesize = $_FILES["file"]["size"];
 	if (!$logo){
		if (empty($file_basename)){
			$erreurs['file'] = _T('encheres:erreur_choisir_image');
			}
		elseif ($file_ext != ".png" AND $file_ext != ".gif" AND $file_ext != ".jpg" AND $file_ext != ".jpeg"){
			$erreurs['file'] = _T('encheres:formats_autorises');
				}

		elseif ($filesize > 3000000){
			$erreurs['file'] = _T('encheres:taille_document');
				}
		}
	return $erreurs;
}

/* @annotation: Actualisation de la base de donnée */
function formulaires_logo_breve_traiter_dist($id_breve,$logo='',$url_retour=''){
$url_retour= str_replace('&amp;','&',$url_retour); 

	if (isset($_POST['execute'])) {
 		if (!$logo){
		$filename = $_FILES["file"]["name"];

		$file_basename = substr($filename, 0, strripos($filename, '.')); // strip extention
		$file_ext = substr($filename, strripos($filename, '.')); // strip name
		$filesize = $_FILES["file"]["size"];
 
		// rename file
		if ($file_ext == '.jpeg')$file_ext = '.jpg';
		$newfilename = "breveon".$id_breve . $file_ext;
 
			if (file_exists("IMG/" . $newfilename)) {
				// file already exists error
				$error = "You have already submitted this file.";
			} else {
				move_uploaded_file($_FILES["file"]["tmp_name"], "IMG/" . $newfilename);

				if($url_retour) {header('location:'.$url_retour);}
			}

		}
 		if ($logo){
		unlink($logo);
		if($url_retour) {header('location:'.$url_retour);}
		}
	}


}
?>