<?php
try{
     $bdd = new PDO ('mysql:host=localhost;dbname=sow2', 'root', '');
     $bdd -> exec ('SET NAMES utf8');
}
catch(Exception $e)
{
     die('Erreur : '.$e->getMessage());
}
?>