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

   $reqpanier = $bdd->query("SELECT SUM(Prix*Quantite) FROM produits INNER JOIN panier ON produits.ID_Produits = panier.Produit WHERE panier.Utilisateur = '$id'")->fetch(); // On récupére l'opération sur la table panier et produit correspondant au total du prix d'un panier.

$Total = $reqpanier;

require_once "PayPalPayment.php"; //On fait appel à un script paypal nous permettant de réaliser nos transactions.

$success = 0; // Variable booléen permettant de savoir si la transaction s'est bien déroulée ou non.
$msg = "Une erreur est survenue, merci de bien vouloir réessayer ultérieurement...";// Message d'erreur en cas d'échec.
$paypal_response = [];//Tableau contenant l'ensemble des éléments envoyés par l'API PayPal.

$payer = new PayPalPayment(); // On initialise un nouvel objet $payer.
$payer->setSandboxMode(1); //On active le mode sandbox
$payer->setClientID("AbrCTmKvOwIDwlf-Iid7-U4zRw4FnCGAbza68olXGWH7mYtuOvjDFDhZH6hTZHUdSa5Lh99HnY-mbqjl"); //On indique l'ID client.
$payer->setSecret("EOJJi4rq_xPidPd0zmb7b9Rscj8ApD8PxuTL_FROIlUPiUqfLU6f0AdGh9Ym-4gx2tgTJ4Nv0nJWS6i0");//On indique le code secret du client.

/*On renseigne pour l'API paypal un formulaire indispensable pour effectuer une transaction. On précise notamment le prix du panier. 
*/
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
            "total" => strval($Total['0']),
            "currency" => "EUR"
         ],
         "description" => "Achat article du BDE CESI"
      ]
   ]
];

//On utilise la fonction CreatPayment en lui donnant l'ensemble des données renseignées ci-dessus.
$paypal_response = $payer->createPayment($payment_data);
$paypal_response = json_decode($paypal_response); //On reçoit une réponse paypal sous forme de JSON. On utilise donc json_decode pour le décoder.

if (!empty($paypal_response->id)) {//On continu si Paypal à bien envoyé un id.
   $insert = $bdd->prepare("INSERT INTO paiements (payment_id, payment_status, payment_amount, payment_currency, payment_date, payer_email) VALUES (:payment_id, :payment_status, :payment_amount, :payment_currency, NOW(), '')");
   //On insert une nouvelle entrée dans la table paiement avec nos informations.
   
   $insert_ok = $insert->execute(array(
         "payment_id" => $paypal_response->id,
         "payment_status" => $paypal_response->state,
         "payment_amount" => $paypal_response->transactions[0]->amount->total,
         "payment_currency" => $paypal_response->transactions[0]->amount->currency,
         //Ces données correspondent aux réponses données par le serveur Paypal. 
      ));

   if ($insert_ok) {
      $success = 1; //Si l'entrée en base de données est bien réalisée, on passe le statut en 1 et on vide le msg.
      $msg = "";
   }
} else {
   $msg = "Une erreur est survenue durant la communication avec les serveurs de PayPal. Merci de bien vouloir réessayer ultérieurement."; // Si ce n'est pas le cas, on renvoie un autre message d'erreur.
}

echo json_encode(["success" => $success, "msg" => $msg, "paypal_response" => $paypal_response]); 
//On affiche un table de données qui sera récupéré par le client-side encodé en JSON.

}