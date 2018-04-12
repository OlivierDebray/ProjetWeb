<?php
session_start();
try{
	$bdd = new PDO('mysql:host=localhost;dbname=projetweb', 'root', '');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(Exception $e){

	die('Erreur:' . $e->getmessage());
}