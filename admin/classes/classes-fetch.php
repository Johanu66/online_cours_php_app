<?php
    include("../control-if-user-is-connected.php");

    // noms des colonnes dans l'ordre
    $colonne = array("nom_classe", "desc_classe", "statut_classe");

    $query = "";

    $output = array();

    $query .= "SELECT * FROM classe WHERE del_classe = '0' "; // changer

    if(isset($_POST["search"]["value"]))
    {	// changer les colonnes à rechercher
        $query .= 'AND ( id_classe LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR nom_classe LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR desc_classe LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR statut_classe LIKE "%'.$_POST["search"]["value"].'%" ) ';
    }

    // Filtrage dans le tableau
    if(isset($_POST['order']))
    {
        $query .= 'ORDER BY '.$colonne[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY id_classe DESC ';
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
        $sub_array[] = $row['nom_classe'];
        $sub_array[] = $row['desc_classe'];
        if($row['statut_classe']=="Actif"){
            $sub_array[] = "<span class='btn btn-pill btn-success mb-1'>".$row['statut_classe']."</span>";
        }
        else if($row['statut_classe']=="Inactif"){
            $sub_array[] = "<span class='btn btn-pill btn-danger mb-1'>".$row['statut_classe']."</span>";
        }
        $actions = '<div class="button-drop-style-one btn-default-bg" style="position: relative;">
        <button type="button" class="btn btn-custon-four btn-default dropdown-toggle1" data-toggle="dropdown">Actions<i class="fa fa-angle-down"></i>
            </button>
        <ul class="dropdown-menu btn-dropdown-menu another-drop-pro-two dropdown-toggle1 sp-btn-dp-1" role="menu">
        <li><a href="#" class="dropdown-item view" id="'.$row["id_classe"].'">Consulter</a></li>';
        if($_SESSION['id_type_compte'] <= 3){
            $actions .= "<li><a class='dropdown-item' href='classes-edit.php?id=".$row['id_classe']."'>Modifier</a></li>";
        }
        if($_SESSION['id_type_compte'] <= 2){
            $actions .= "<li><a class='dropdown-item delete' href='#' id='".$row['id_classe']."'>Supprimer</a></li>";
        }
        if($_SESSION['id_type_compte'] <= 1){
            if($row['statut_classe']=="Actif"){
                $actions .= "<li><a class='dropdown-item desactivation' href='#' id='".$row["id_classe"]."'>Désactiver</a></li>";
            }
            else if($row['statut_classe']=="Inactif"){
                $actions .= "<li><a class='dropdown-item activation' href='#' id='".$row["id_classe"]."'>Activer</a></li>";
            }
        }
        $actions .= '</ul>
        </div>';
        $sub_array[] = $actions;
        $data[] = $sub_array;
    }

    function get_total_all_records($bdd)
    {
        $statement = $bdd->prepare("SELECT * FROM classe WHERE del_classe = '0'"); // same query as above
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