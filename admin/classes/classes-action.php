<?php

    if(isset($_POST['btn_action'])){
        if($_POST['btn_action']=='consulter'){
            include("../control-if-user-is-connected.php");
            $query = "SELECT * FROM classe
            WHERE id_classe = ?";

            $statement = $bdd->prepare($query);
            $statement->execute(array($_POST["id_view"]));
            $result = $statement->fetchAll();
            $output = '
            <div class="table-responsive">
                <table class="table">
            ';

            //$nom_classe ='';

            foreach ($result as $row) {
                $output .= '
                <tr>
                    <td>Nom</td>
                    <td>' . $row["nom_classe"] . '</td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>' . $row["desc_classe"] . '</td>
                </tr>
                <tr>
                    <td>Statut</td>
                    <td>';
                if($row['statut_classe']=="Actif"){
                    $output .= "<span class='btn btn-pill btn-success mb-1'>".$row['statut_classe']."</span>";
                }
                else if($row['statut_classe']=="Inactif"){
                    $output .= "<span class='btn btn-pill btn-danger mb-1'>".$row['statut_classe']."</span>";
                }
                $output .= '</td>
                </tr>
                <tr>
                    <td>Date de création</td>
                    <td>' . date("d-m-Y", strtotime($row["date_create_classe"])) . ' à ' . date("H:i", strtotime($row["date_create_classe"])) . '</td>
                </tr>
                <tr>
                    <td>Dernièrement modifié le</td>
                    <td>' . date("d-m-Y", strtotime($row["date_last_modif_classe"])) . ' à ' . date("H:i", strtotime($row["date_last_modif_classe"])) . '</td>
                </tr>
                <tr>
                    <td>Enregistrée par</td>
                    <td>' . $row['user_create_classe'] . '</td>
                </tr>
                <tr>
                    <td>Dernièrement modifié par</td>
                    <td>' . $row['user_create_classe'] . '</td>
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
            update(" classe ",[
                "statut_classe" => "Actif"
            ]," id_classe = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM classe WHERE id_classe = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "La classe ".$result['nom_classe']." est désormais actif.";
            echo json_encode($output);
        }

        if($_POST['btn_action']=='desactivation'){
            include("../control-if-user-is-connected.php");
            update(" classe ",[
                "statut_classe" => "Inactif"
            ]," id_classe = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM classe WHERE id_classe = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "La classe ".$result['nom_classe']." est désormais inactif.";
            echo json_encode($output);
        }

        if($_POST['btn_action']=='delete'){
            include("../control-if-user-is-connected.php");
            $now = new DateTime();
            update(" classe ",[
                "del_classe" => 1,
                "date_del_classe" => $now->format('Y-m-d H:i:s'),
                "user_del_classe" => $_SESSION['nom']." ".$_SESSION['prenom']
            ]," id_classe = '".$_POST['id']."'");
            $statement = $bdd->prepare("SELECT * FROM classe WHERE id_classe = ?");
            $statement->execute(array($_POST['id']));
            $result = $statement->fetch();
            $output = "La classe ".$result['nom_classe']." a été supprimée.";
            echo json_encode($output);
        }
    }