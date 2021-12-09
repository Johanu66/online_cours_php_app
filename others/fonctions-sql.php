<?php
    function get_menu_by_compte($id_compte)
    {
        include("db.php");
        $statement1 = $bdd->prepare("SELECT * FROM assoc_compte_and_menu WHERE id_compte_fk_assoc_compte_and_menu = ? AND statut_assoc_compte_and_menu = 'Actif'");
        $statement1->execute(array($id_compte));
        $menu = [];
        while($result = $statement1->fetch()){
            $statement2 = $bdd->prepare("SELECT * FROM menu WHERE id_menu = ?");
            $statement2->execute(array($result["id_menu_fk_assoc_compte_and_menu"]));
            $result1 = $statement2->fetch();
            array_push($menu, $result1['lib_menu']);
        }
        return $menu;
    }

    function get_specialite_by_id($id_specialite)
    {
        include("db.php");
        $statement = $bdd->prepare("SELECT * FROM specialite WHERE id_specialite = ? AND statut_specialite = 'Actif'");
        $statement->execute(array($id_specialite));
        $specialite = $statement->fetch();
        return $specialite["nom_specialite"];
    }

    function insert($table, $column_value){
        include("db.php");
        $columns = [];
        $values = [];
        foreach($column_value as $column => $value){
            $columns[] = $column;
            $values[] = "'".$value."'";
        }
        $query = "INSERT INTO ".$table." (".implode(',',$columns).") VALUES (".implode(',',$values).")";
        $bdd->query($query);
    }

    function update($table, $column_value, $condition){
        include("db.php");
        $column_value_normal_for_requete = [];
        foreach($column_value as $column => $value){
            $column_value_normal_for_requete[] = $column." = '".$value."'";
        }
        $query = "UPDATE ".$table." SET ".implode(' , ',$column_value_normal_for_requete)." WHERE ".$condition;
        $bdd->query($query);
    }

    function delete($table, $condition){
        include("db.php");
        $query = "DELETE FROM ".$table." WHERE ".$condition;
        $bdd->query($query);
    }

    function nombre($table, $condition){
        include('db.php');
        $query = "SELECT * FROM ".$table." WHERE ".$condition;
        $statement = $bdd->query($query);
        $statement->execute();
        return $statement->rowCount();
    }

?>