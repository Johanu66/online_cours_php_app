<?php
    include("../control-if-user-is-connected.php");

    // noms des colonnes dans l'ordre
    $colonne = array("photo_personne", "nom_personne", "prenom_personne", "sexe_personne", "nom_classe", "tel_personne", "email_personne", "statut_personne");

    $query = "";

    $output = array();

    $query .= "SELECT * FROM etudiant INNER JOIN personne ON id_personne_fk_etudiant=id_personne INNER JOIN classe ON id_classe_fk_etudiant=id_classe WHERE del_personne='0' AND statut_personne='En attente' "; // changer

    if(isset($_POST["search"]["value"]))
    {	// changer les colonnes à rechercher
        $query .= 'AND ( nom_personne LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR prenom_personne LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR sexe_personne LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR nom_classe LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR tel_personne LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR email_personne LIKE "%'.$_POST["search"]["value"].'%" ';
        $query .= 'OR statut_personne LIKE "%'.$_POST["search"]["value"].'%" ) ';
    }

    // Filtrage dans le tableau
    if(isset($_POST['order']))
    {
        $query .= 'ORDER BY '.$colonne[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY id_etudiant DESC ';
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
        $sub_array[] = "<div style='width: 40px; height: 40px; overflow: hidden; border-radius: 50%;'>
            <img style='height: 100%; margin: auto;' src='../../img/personnes/".$row['photo_personne']."'>
        </div>";
        $sub_array[] = $row['matricule_etudiant'];
        $sub_array[] = $row['nom_personne'];
        $sub_array[] = $row['prenom_personne'];
        $sub_array[] = $row['sexe_personne'];
        $sub_array[] = $row['nom_classe'];
        $sub_array[] = $row['tel_personne'];
        $sub_array[] = $row['email_personne'];
        $sub_array[] = "<span class='btn btn-pill btn-warning mb-1'>".$row['statut_personne']."</span>";
        $actions = '<div class="button-drop-style-one btn-default-bg" style="position: relative;">
        <button type="button" class="btn btn-custon-four btn-default dropdown-toggle1" data-toggle="dropdown">Actions<i class="fa fa-angle-down"></i>
            </button>
        <ul class="dropdown-menu btn-dropdown-menu another-drop-pro-two dropdown-toggle1 sp-btn-dp-1" role="menu">';
        $actions .= "<li><a class='dropdown-item delete' href='#' id='".$row['id_etudiant']."'>Rejeter</a></li>";
        $actions .= "<li><a class='dropdown-item activation' href='#' id='".$row["id_etudiant"]."'>Valider</a></li>";
        $actions .= '</ul>
        </div>';
        $sub_array[] = $actions;
        $data[] = $sub_array;
    }

    function get_total_all_records($bdd)
    {
        $statement = $bdd->prepare("SELECT * FROM etudiant INNER JOIN personne ON id_personne_fk_etudiant=id_personne INNER JOIN classe ON id_classe_fk_etudiant=id_classe WHERE del_personne='0' AND statut_personne='En attente'"); // same query as above
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