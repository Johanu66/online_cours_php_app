<?php
    //Connexion à la bd
    try{
        $bdd = new PDO("mysql:host=localhost;dbname=tqffjfwm_oclass;charset=utf8","tqffjfwm_oclass",'o3tJ$cA#1:to$tJotc', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }
