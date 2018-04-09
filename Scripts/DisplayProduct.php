<?php
/**
 * Created by PhpStorm.
 * User: Théo
 * Date: 09/04/2018
 * Time: 15:38
 */

try{

    $bdd = new PDO('mysqlhost=localhost;dbname=projetweb;charset=utf8', 'root','');
    $getNewest = $bdd->query("SELECT ");
}
catch(Exception $e){
    echo " Exception : " .$e->getMessage(). "\n";
}

