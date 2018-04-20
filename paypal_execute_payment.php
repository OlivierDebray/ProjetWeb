<?php session_start();

try{
	$bdd = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '');// On se connecte à notre base de données.
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(Exception $e){

	die('Erreur:' . $e->getmessage());//On affiche une exception quand la connexion n'a pas été effectué.
}


require_once "PayPalPayment.php";//On fait appel à un script paypal nous permettant de réaliser nos transactions.


$success = 0; // Variable booléen permettant de savoir si la transaction s'est bien déroulée ou non.
$msg = "Une erreur est survenue, merci de bien vouloir réessayer ultérieurement...";// Message d'erreur en cas d'échec.
$paypal_response = [];//Tableau contenant l'ensemble des éléments envoyés par l'API PayPal

if (!empty($_POST['paymentID']) AND !empty($_POST['payerID'])) {//On récupère les deux paramètres paymentID et payerID avec POST.
   $paymentID = htmlspecialchars($_POST['paymentID']);
   $payerID = htmlspecialchars($_POST['payerID']);

  $payer = new PayPalPayment(); // On initialise un nouvel objet $payer.
   $payer->setSandboxMode(1); //On active le mode sandbox
      $payer->setClientID("AbrCTmKvOwIDwlf-Iid7-U4zRw4FnCGAbza68olXGWH7mYtuOvjDFDhZH6hTZHUdSa5Lh99HnY-mbqjl"); //On indique l'ID client.
$payer->setSecret("EOJJi4rq_xPidPd0zmb7b9Rscj8ApD8PxuTL_FROIlUPiUqfLU6f0AdGh9Ym-4gx2tgTJ4Nv0nJWS6i0");//On indique le code secret du client.

$payment = $bdd->prepare('SELECT * FROM paiements WHERE payment_id = ?'); //On récupère le paiement à exécuter à l'aide de son paymentID récupéré avec POST.
$payment->execute(array($paymentID));
$payment = $payment->fetch();

if ($payment) {//Si le paiement est bien trouvé, on continu.
   $paypal_response = $payer->executePayment($paymentID, $payerID);//On utilise la fonction executePayement en lui passant en paramètre paymentID et payerID.
   $paypal_response = json_decode($paypal_response);
   //On récupère la réponse de paypal et on la décode à l'aide de json_decode.

   $update_payment = $bdd->prepare('UPDATE paiements SET payment_status = ?, payer_email = ? WHERE payment_id = ?'); //On met à jour le statut du paiement dans la table paiement lors du succès de la transaction.
   $update_payment->execute(array($paypal_response->state, $paypal_response->payer->payer_info->email, $paymentID));

   if ($paypal_response->state == "approved") {//On vérifie que le paiement a bien été approuvé.
      $success = 1;// On passe le statut à 1 et on vide le msg.
      $msg = "";
   } else {
      $msg = "Une erreur est survenue durant l'approbation de votre paiement. Merci de réessayer ultérieurement ou contacter un administrateur du site.";//Si le paiement n'est pas approuvé, on affiche une erreur.
   }
} else {
   $msg = "Votre paiement n'a pas été trouvé dans notre base de données. Merci de réessayer ultérieurement ou contacter un administrateur du site. (Votre compte PayPal n'a pas été débité)";
   //On affiche une erreur si le paiement n'a pas été trouvé dans la table.
}

}
echo json_encode(["success" => $success, "msg" => $msg, "paypal_response" => $paypal_response]);
//On affiche un tableau de données utilisé par le client-side.

if(isset($_SESSION["id"])) {
   $id= $_SESSION["id"];

   $bdd->query("DELETE FROM panier WHERE Utilisateur = '$id'");
   //On supprime le panier à la fin de la transaction.
}