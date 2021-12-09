<?php
    include("../control-if-user-is-connected.php");

    // noms des colonnes dans l'ordre
    $colonne = array("nom_etudiant", "nom_classe", "nom_professeur", "statut_signale");

    $query = "";

    $output = array();

    $query .= "SELECT id_signale, statut_signale, nom_classe, personne_etudiant.nom_personne AS nom_etudiant, personne_etudiant.prenom_personne AS prenom_etudiant, personne_professeur.nom_personne AS nom_professeur, personne_professeur.prenom_personne AS prenom_professeur FROM signale
    INNER JOIN etudiant ON id_etudiant_fk_signale=id_etudiant
    INNER JOIN personne AS personne_etudiant ON id_personne_fk_etudiant=personne_etudiant.id_personne
    INNER JOIN classe ON id_classe_fk_etudiant=id_classe
    INNER JOIN professeur ON id_professeur_fk_signale=id_professeur
    INNER JOIN personne AS personne_professeur ON id_personne_fk_professeur=personne_professeur.id_personne
    WHERE del_signale = '0' "; // changer

    if(isset($_POST["search"]["value"]))
    {	// changer les colonnes à rechercher
        $query .= 'AND ( personne_etudiant.nom_personne LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR nom_classe LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR personne_professeur.nom_personne LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR statut_signale LIKE "%'.$_POST["search"]["value"].'%" ) ';
    }

    // Filtrage dans le tableau
    if(isset($_POST['order']))
    {
        $query .= 'ORDER BY '.$colonne[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY id_signale DESC ';
    }

    if($_POST['length'] != -1)
    {
        $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $statement = $bdd->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    $data = array();

    $filtered_rows = $statement->rowCount();

    foreach($result as $row)
    {
        $sub_array = array(); // tenir compte de l'ordre dans le tableau
        $sub_array[] = $row['nom_etudiant'].' '.$row['prenom_etudiant'];
        $sub_array[] = $row['nom_classe'];
        $sub_array[] = $row['nom_professeur'].' '.$row['prenom_professeur'];
        if($row['statut_signale']=="Lu"){
            $sub_array[] = "<span class='btn btn-pill btn-success mb-1'>".$row['statut_signale']."</span>";
        }
        else if($row['statut_signale']=="Non lu"){
            $sub_array[] = "<span class='btn btn-pill btn-danger mb-1'>".$row['statut_signale']."</span>";
        }
        $actions = '<div class="button-drop-style-one btn-default-bg" style="position: relative;">
        <button type="button" class="btn btn-custon-four btn-default dropdown-toggle1" data-toggle="dropdown">Actions<i class="fa fa-angle-down"></i>
            </button>
        <ul class="dropdown-menu btn-dropdown-menu another-drop-pro-two dropdown-toggle1 sp-btn-dp-1" role="menu">
        <li><a href="#" class="dropdown-item view" id="'.$row["id_signale"].'">Consulter</a></li>';
        if($row['statut_signale']=="Lu"){
            $actions .= "<li><a class='dropdown-item masquer_non_comme_lu' href='#' id='".$row["id_signale"]."'>Masquer comme non lu</a></li>";
        }
        else if($row['statut_signale']=="Non lu"){
            $actions .= "<li><a class='dropdown-item masquer_comme_lu' href='#' id='".$row["id_signale"]."'>Masquer comme lu</a></li>";
        }
        $actions .= '</ul>
        </div>';
        $sub_array[] = $actions;
        $data[] = $sub_array;
    }

    function get_total_all_records($bdd)
    {
        $statement = $bdd->prepare("SELECT id_signale, statut_signale, nom_classe, personne_etudiant.nom_personne AS nom_etudiant, personne_etudiant.prenom_personne AS prenom_etudiant, personne_professeur.nom_personne AS nom_professeur, personne_professeur.prenom_personne AS prenom_professeur FROM signale
        INNER JOIN etudiant ON id_etudiant_fk_signale=id_etudiant
        INNER JOIN personne AS personne_etudiant ON id_personne_fk_etudiant=personne_etudiant.id_personne
        INNER JOIN classe ON id_classe_fk_etudiant=id_classe
        INNER JOIN professeur ON id_professeur_fk_signale=id_professeur
        INNER JOIN personne AS personne_professeur ON id_personne_fk_professeur=personne_professeur.id_personne
        WHERE del_signale = '0'"); // same query as above
        $statement->execute();
        return $statement->rowCount();
    }

    $output = array(
        "draw"			=>	intval($_POST["draw"]),
        "recordsTotal"  	=>  get_total_all_records($bdd),
        "recordsFiltered" 	=> 	$filtered_rows,
        "data"				=>	$data
    );

    echo json_encode($output);
?>