<?php
try{
     $bdd = new PDO ('mysql:host=database-1.cufxjlpvayyu.eu-west-3.rds.amazonaws.com;dbname=sow2', 'root', 'Houzin1435');
     $bdd -> exec ('SET NAMES utf8');
}
catch(Exception $e)
{
     die('Erreur : '.$e->getMessage());
}
?>
