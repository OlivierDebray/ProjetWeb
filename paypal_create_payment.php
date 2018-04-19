<?php session_start();

try{
	$bdd = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '');// On se connecte à notre base de données.
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(Exception $e){

	die('Erreur:' . $e->getmessage());//On affiche une exception quand la connexion n'a pas été effectué.
}

if(isset($_SESSION["id"])) {//On vérifie que l'utilisateur est bien connecté.
   $id= $_SESSION["id"];

   $reqpanier = $bdd->query("SELECT * FROM produits INNER JOIN panier ON produits.ID_Produits = panier.Produit WHERE panier.Utilisateur = '$id'")->fetch();

   $Total = $reqpanier['Prix'];
   

require_once "PayPalPayment.php";

$success = 0;
$msg = "Une erreur est survenue, merci de bien vouloir réessayer ultérieurement...";
$paypal_response = [];

$payer = new PayPalPayment();
$payer->setSandboxMode(1);
$payer->setClientID("AbrCTmKvOwIDwlf-Iid7-U4zRw4FnCGAbza68olXGWH7mYtuOvjDFDhZH6hTZHUdSa5Lh99HnY-mbqjl");
$payer->setSecret("EOJJi4rq_xPidPd0zmb7b9Rscj8ApD8PxuTL_FROIlUPiUqfLU6f0AdGh9Ym-4gx2tgTJ4Nv0nJWS6i0");

$payment_data = [
   "intent" => "sale",
   "redirect_urls" => [
      "return_url" => "http://localhost/ProjetWeb",
      "cancel_url" => "http://localhost/ProjetWeb"
   ],
   "payer" => [
      "payment_method" => "paypal"
   ],
   "transactions" => [
      [
         "amount" => [
            "total" => strval($Total),
            "currency" => "EUR"
         ],
         "description" => "Achat article du BDE CESI"
      ]
   ]
];


$paypal_response = $payer->createPayment($payment_data);
$paypal_response = json_decode($paypal_response);

if (!empty($paypal_response->id)) {
   $insert = $bdd->prepare("INSERT INTO paiements (payment_id, payment_status, payment_amount, payment_currency, payment_date, payer_email) VALUES (:payment_id, :payment_status, :payment_amount, :payment_currency, NOW(), '')");
   
   $insert_ok = $insert->execute(array(
         "payment_id" => $paypal_response->id,
         "payment_status" => $paypal_response->state,
         "payment_amount" => $paypal_response->transactions[0]->amount->total,
         "payment_currency" => $paypal_response->transactions[0]->amount->currency,
      ));

   if ($insert_ok) {
      $success = 1;
      $msg = "";
   }
} else {
   $msg = "Une erreur est survenue durant la communication avec les serveurs de PayPal. Merci de bien vouloir réessayer ultérieurement.";
}

echo json_encode(["success" => $success, "msg" => $msg, "paypal_response" => $paypal_response]);

}