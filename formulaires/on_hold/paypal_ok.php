 
<?php
 echo "<h1>payement ok</h1>";
 
 print_r($_POST);
 
 
 
if(isset($_GET['tx'])){
 
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-synch';
 
$tx_token = $_GET['tx'];
//$auth_token : Entrez votre "jeton" d'identification qui vous est scpécifié sur votre compte paypal
$auth_token = "kuyvchghfgjhfxklgjhxkldfhgxkldfgdfg";
$req .= "&tx=$tx_token&at=$auth_token";
 
// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$custom = $_POST['custom'];
$num_cart_items = $_POST['num_cart_items'];
$amount = $_POST['mc_gross'];
 
 
if (!$fp) {
// HTTP ERROR
 
//VERIFICATION
echo"error HTTP!";
 
} else {
fputs ($fp, $header . $req);
// read the body data 
$res = '';
$headerdone = false;
while (!feof($fp)) {
$line = fgets ($fp, 1024);
if (strcmp($line, "\r\n") == 0) {
// read the header
$headerdone = true;
//echo$headerdone;
}
else if ($headerdone)
{
 
// header has been read. now read the contents
$res .= $line;
}
}
 
// parse the data
$lines = explode("\n", $res);
$keyarray = array();
if (strcmp ($lines[0], "SUCCESS") == 0) {
 
for ($i=1; $i<count($lines);$i++){
list($key,$val) = explode("=", $lines[$i]);
$keyarray[urldecode($key)] = urldecode($val);
}
 
//print_r($keyarray);
 
 
$num_cart_items = $keyarray['num_cart_items'];
$firstname = $keyarray['first_name'];
$lastname = $keyarray['last_name'];
$txn_id = $keyarray['txn_id'];
$amount = $keyarray['mc_gross'];
$payment_date = $keyarray['payment_date'];
$payment_currency = $keyarray['mc_currency'];
 
echo ("<p><h3>Merci pour votre achat!</h3></p>");
echo ("<b>Détails du paiment</b><br>\n");
echo ("<li>Nom: $firstname $lastname</li>\n");
echo ("<li>transaction numero: $txn_id</li>\n");
echo ("<li>Coût de la transaction: $amount $payment_currency</li>\n");
echo ("<li>date de la transaction: $payment_date</li>\n");
 
for ($k=1; $k<=$num_cart_items;$k++){
$variable_name = $keyarray['item_name'.$k.''];
$quantity = $keyarray['quantity'.$k.''];
echo"<li>objet acheté n°".$k."= ".$variable_name."</li>\n" ;
echo"<li>Quantité acheté= ".$quantity."</li>\n"  ;
}
 
 
$payment_gross = $keyarray['payment_gross'];
$custom = $keyarray['custom'];
 
 
 
echo ("<p>La transaction s'est bien effectuée, un email de confirmation vous a été envoyé.<br> Vous devez vous identifez sur le site <a href='https://www.paypal.com'>www.paypal.com</a> pour voir les détails de cette transaction.<br>");
}
else if (strcmp ($lines[0], "FAIL") == 0) {
 
//VERIFICATION
echo"Il y a eu eu une erreur lors de la redirection depuis paypal. Vérifier que le paiment s'est bien effectué.";
 
}
 
}
 
fclose ($fp);}
?>
