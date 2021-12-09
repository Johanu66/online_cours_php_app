<?php
    include("../control-if-user-is-connected.php");

    // noms des colonnes dans l'ordre
    $colonne = array("intitule_cours", "nom_matiere", "date_debut_cours", "date_fin_cours", "prenom_personne", "statut_cours");

    $query = "";

    $output = array();

    $query .= "SELECT * FROM cours INNER JOIN classe ON id_classe_fk_cours=id_classe INNER JOIN matiere ON id_matiere_fk_cours=id_matiere INNER JOIN professeur ON id_professeur_fk_cours=id_professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne WHERE del_cours='0' AND id_classe=? "; // changer

    if(isset($_POST["search"]["value"]))
    {	// changer les colonnes à rechercher
        $query .= 'AND ( intitule_cours LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR nom_matiere LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR date_debut_cours LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR date_fin_cours LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR prenom_personne LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR statut_cours LIKE "%'.$_POST["search"]["value"].'%" ) ';
    }

    // Filtrage dans le tableau
    if(isset($_POST['order']))
    {
        $query .= 'ORDER BY '.$colonne[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY id_cours DESC ';
    }

    if($_POST['length'] != -1)
    {
        $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $statement = $bdd->prepare($query);

    $statement->execute(array(get_student_class_id($_SESSION['id'])));

    $result = $statement->fetchAll();

    $data = array();

    $filtered_rows = $statement->rowCount();

    foreach($result as $row)
    {
        $sub_array = array(); // tenir compte de l'ordre dans le tableau
        $sub_array[] = $row['intitule_cours'];
        $sub_array[] = $row['nom_matiere'];
        $sub_array[] = date("d-m-Y", strtotime($row["date_debut_cours"])) . ' à ' . date("H:i", strtotime($row["date_debut_cours"]));
        if($row['date_fin_cours']!=null){
            $sub_array[] = date("d-m-Y", strtotime($row["date_fin_cours"])) . ' à ' . date("H:i", strtotime($row["date_fin_cours"]));
        }
        else{
            $sub_array[] = "";
        }
        $sub_array[] = $row['prenom_personne']." ".$row['nom_personne'];
        if($row['statut_cours']=="Actif"){
            $sub_array[] = "<span class='btn btn-pill btn-success mb-1'>".$row['statut_cours']."</span>";
        }
        else if($row['statut_cours']=="Inactif"){
            $sub_array[] = "<span class='btn btn-pill btn-danger mb-1'>".$row['statut_cours']."</span>";
        }
        $actions = '<div class="button-drop-style-one btn-default-bg" style="position: relative;">
        <button type="button" class="btn btn-custon-four btn-default dropdown-toggle1" data-toggle="dropdown">Actions<i class="fa fa-angle-down"></i>
            </button>
        <ul class="dropdown-menu btn-dropdown-menu another-drop-pro-two dropdown-toggle1 sp-btn-dp-1" role="menu">
        <li><a href="#" class="dropdown-item telechargement" id="'.$row["id_cours"].'">Télécharger tous les fichiers</a></li>
        <li><a href="#" class="dropdown-item view" id="'.$row["id_cours"].'">Consulter</a></li>';
        $actions .= '</ul>
        </div>';
        $sub_array[] = $actions;
        $data[] = $sub_array;
    }

    function get_total_all_records($bdd)
    {
        $statement = $bdd->prepare("SELECT * FROM cours INNER JOIN classe ON id_classe_fk_cours=id_classe INNER JOIN matiere ON id_matiere_fk_cours=id_matiere INNER JOIN professeur ON id_professeur_fk_cours=id_professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne WHERE del_cours='0' AND id_classe=?"); // same query as above
        $statement->execute(array(get_student_class_id($_SESSION['id'])));
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