<?php session_start();

try{
	$bdd = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '');// On se connecte à notre base de données.
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(Exception $e){

	die('Erreur:' . $e->getmessage());//On affiche une exception quand la connexion n'a pas été effectué.
}


require_once "PayPalPayment.php";

$success = 0;
$msg = "Une erreur est arrivée, merci de bien vouloir réessayer ultérieurement...";
$paypal_response = [];

if (!empty($_POST['paymentID']) AND !empty($_POST['payerID'])) {
   $paymentID = htmlspecialchars($_POST['paymentID']);
   $payerID = htmlspecialchars($_POST['payerID']);

   $payer = new PayPalPayment();
   $payer->setSandboxMode(1);
   $payer->setClientID("AbrCTmKvOwIDwlf-Iid7-U4zRw4FnCGAbza68olXGWH7mYtuOvjDFDhZH6hTZHUdSa5Lh99HnY-mbqjl");
	$payer->setSecret("EOJJi4rq_xPidPd0zmb7b9Rscj8ApD8PxuTL_FROIlUPiUqfLU6f0AdGh9Ym-4gx2tgTJ4Nv0nJWS6i0");

   $payment = $bdd->prepare('SELECT * FROM paiements WHERE payment_id = ?');
   $payment->execute(array($paymentID));
   $payment = $payment->fetch();

   if ($payment) {
      $paypal_response = $payer->executePayment($paymentID, $payerID);
      $paypal_response = json_decode($paypal_response);

      $update_payment = $bdd->prepare('UPDATE paiements SET payment_status = ?, payer_email = ? WHERE payment_id = ?');
      $update_payment->execute(array($paypal_response->state, $paypal_response->payer->payer_info->email, $paymentID));

      if ($paypal_response->state == "approved") {
         $success = 1;
         $msg = "";
      } else {
         $msg = "Une erreur est survenue durant l'approbation de votre paiement. Merci de réessayer ultérieurement ou contacter un administrateur du site.";
      }
   } else {
      $msg = "Votre paiement n'a pas été trouvé dans notre base de données. Merci de réessayer ultérieurement ou contacter un administrateur du site. (Votre compte PayPal n'a pas été débité)";
   }

}
echo json_encode(["success" => $success, "msg" => $msg, "paypal_response" => $paypal_response]);

if(isset($_SESSION["id"])) {
   $id= $_SESSION["id"];

   $bdd->query("DELETE FROM panier WHERE Utilisateur = '$id'");
}