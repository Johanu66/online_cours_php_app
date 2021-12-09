<?php

    if(isset($_POST['btn_action'])){
        if($_POST['btn_action']=='consulter'){
            include("../control-if-user-is-connected.php");
            $query = "SELECT * FROM matiere
            WHERE id_matiere = ?";

            $statement = $bdd->prepare($query);
            $statement->execute(array($_POST["id_view"]));
            $result = $statement->fetchAll();
            $output = '
            <div class="table-responsive">
                <table class="table">
            ';

            //$nom_matiere ='';

            foreach ($result as $row) {
                $output .= '
                <tr>
                    <td>Nom</td>
                    <td>' . $row["nom_matiere"] . '</td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>' . $row["desc_matiere"] . '</td>
                </tr>
                <tr>
                    <td>Statut</td>
                    <td>';
                if($row['statut_matiere']=="Actif"){
                    $output .= "<span class='btn btn-pill btn-success mb-1'>".$row['statut_matiere']."</span>";
                }
                else if($row['statut_matiere']=="Inactif"){
                    $output .= "<span class='btn btn-pill btn-danger mb-1'>".$row['statut_matiere']."</span>";
                }
                $output .= '</td>
                </tr>
                <tr>
                    <td>Date de création</td>
                    <td>' . date("d-m-Y", strtotime($row["date_create_matiere"])) . ' à ' . date("H:i", strtotime($row["date_create_matiere"])) . '</td>
                </tr>
                <tr>
                    <td>Dernièrement modifié le</td>
                    <td>' . date("d-m-Y", strtotime($row["date_last_modif_matiere"])) . ' à ' . date("H:i", strtotime($row["date_last_modif_matiere"])) . '</td>
                </tr>
                <tr>
                    <td>Enregistrée par</td>
                    <td>' . $row['user_create_matiere'] . '</td>
                </tr>
                <tr>
                    <td>Dernièrement modifié par</td>
                    <td>' . $row['user_create_matiere'] . '</td>
                </tr>
                ';
            }


            $output .= '
                </table>
            </div>
            ';
            echo json_encode($output);
        }

        if($_POST['btn_action']=='activation'){
            include("../control-if-user-is-connected.php");
            update(" matiere ",[
                "statut_matiere" => "Actif"
            ]," id_matiere = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM matiere WHERE id_matiere = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "La matière ".$result['nom_matiere']." est désormais actif.";
            echo json_encode($output);
        }

        if($_POST['btn_action']=='desactivation'){
            include("../control-if-user-is-connected.php");
            update(" matiere ",[
                "statut_matiere" => "Inactif"
            ]," id_matiere = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM matiere WHERE id_matiere = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "La matière ".$result['nom_matiere']." est désormais inactif.";
            echo json_encode($output);
        }

        if($_POST['btn_action']=='delete'){
            include("../control-if-user-is-connected.php");
            $now = new DateTime();
            update(" matiere ",[
                "del_matiere" => 1,
                "date_del_matiere" => $now->format('Y-m-d H:i:s'),
                "user_del_matiere" => $_SESSION['nom']." ".$_SESSION['prenom']
            ]," id_matiere = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM matiere WHERE id_matiere = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "La matière ".$result['nom_matiere']." a été supprimée.";
            echo json_encode($output);
        }
    }