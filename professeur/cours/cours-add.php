<?php
    include("../control-if-user-is-connected.php");
    if(isset($_POST['submit'])){
        if(!empty($_POST['intitule']) && !empty($_POST['matiere']) && !empty($_POST['classe']) && !empty($_POST['date_debut'])){
            if(!isset($_POST['pas_de_fin']) && empty($_POST['date_fin'])){
                $alert_text = "Veuillez renseigner une date de fin.";
            }
            else{
                $fichier1 = "";
                $fichier2 = "";
                $fichier3 = "";
                $fichier4 = "";
                // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
                if (isset($_FILES['fichier1']) AND $_FILES['fichier1']['error'] == 0)
                {
                    // Testons si le fichier n'est pas trop gros
                    if ($_FILES['fichier1']['size'] <= 1000000000)
                    {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['fichier1']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docx');
                        if (in_array($extension_upload, $extensions_autorisees))
                        {
                            // On peut valider le fichier et le stocker définitivement
                            $fichier1 = htmlspecialchars(basename($_FILES['fichier1']['name']));
                            move_uploaded_file($_FILES['fichier1']['tmp_name'], "../../img/fichiers/".$fichier1);
                            
                        }
                        else{
                            $alert_text = "L'extension du fichier 1 n'est pas acceptable.";
                        }
                    }
                    else{
                        $alert_text = "Le fichier 1 est trop volumineux.";
                    }              
                }
                if (isset($_FILES['fichier2']) AND $_FILES['fichier2']['error'] == 0)
                {
                    // Testons si le fichier n'est pas trop gros
                    if ($_FILES['fichier2']['size'] <= 1000000000)
                    {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['fichier2']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docx');
                        if (in_array($extension_upload, $extensions_autorisees))
                        {
                            // On peut valider le fichier et le stocker définitivement
                            $fichier2 = htmlspecialchars(basename($_FILES['fichier2']['name']));
                            move_uploaded_file($_FILES['fichier2']['tmp_name'], "../../img/fichiers/".$fichier2);
                            
                        }
                        else{
                            $alert_text = "L'extension du fichier 2 n'est pas acceptable.";
                        }
                    }
                    else{
                        $alert_text = "Le fichier 2 est trop volumineux.";
                    }          
                }
                if (isset($_FILES['fichier3']) AND $_FILES['fichier3']['error'] == 0)
                {
                    // Testons si le fichier n'est pas trop gros
                    if ($_FILES['fichier3']['size'] <= 1000000000)
                    {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['fichier3']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docx');
                        if (in_array($extension_upload, $extensions_autorisees))
                        {
                            // On peut valider le fichier et le stocker définitivement
                            $fichier3 = htmlspecialchars(basename($_FILES['fichier3']['name']));
                            move_uploaded_file($_FILES['fichier3']['tmp_name'], "../../img/fichiers/".$fichier3);
                            
                        }
                        else{
                            $alert_text = "L'extension du fichier 3 n'est pas acceptable.";
                        }
                    }
                    else{
                        $alert_text = "Le fichier 3 est trop volumineux.";
                    }        
                }
                if (isset($_FILES['fichier4']) AND $_FILES['fichier4']['error'] == 0)
                {
                    // Testons si le fichier n'est pas trop gros
                    if ($_FILES['fichier4']['size'] <= 1000000000)
                    {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['fichier4']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'pdf', 'doc', 'docx');
                        if (in_array($extension_upload, $extensions_autorisees))
                        {
                            // On peut valider le fichier et le stocker définitivement
                            $fichier4 = htmlspecialchars(basename($_FILES['fichier4']['name']));
                            move_uploaded_file($_FILES['fichier4']['tmp_name'], "../../img/fichiers/".$fichier4);
                            
                        }
                        else{
                            $alert_text = "L'extension du fichier 4 n'est pas acceptable.";
                        }
                    }
                    else{
                        $alert_text = "Le fichier 4 est trop volumineux.";
                    }        
                }
                $intitule = htmlspecialchars($_POST['intitule']);
                $matiere = htmlspecialchars($_POST['matiere']);
                $classe = htmlspecialchars($_POST['classe']);
                $professeur = get_id_prof_by_id_personne($_SESSION['id']);
                $date_debut = htmlspecialchars($_POST['date_debut']);
                $notes = htmlspecialchars($_POST['notes']);
                $now = new DateTime();
                if(!isset($_POST['pas_de_fin']) && !empty($_POST['date_fin'])){
                    $date_fin = $_POST['date_fin'];
                    insert("cours",[
                        "intitule_cours" => $intitule,
                        "id_matiere_fk_cours" => $matiere,
                        "id_classe_fk_cours" => $classe,
                        "id_professeur_fk_cours" => $professeur,
                        "date_debut_cours" => $date_debut,
                        "date_fin_cours" => $date_fin,
                        "notes_cours" => $notes,
                        "fichier_1_cours" => $fichier1,
                        "fichier_2_cours" => $fichier2,
                        "fichier_3_cours" => $fichier3,
                        "fichier_4_cours" => $fichier4,
                        "date_create_cours" => $now->format('Y-m-d H:i:s'),
                        "user_create_cours" => $_SESSION['nom']." ".$_SESSION['prenom'],
                        "date_last_modif_cours" => $now->format('Y-m-d H:i:s'),
                        "user_last_modif_cours" => $_SESSION['nom']." ".$_SESSION['prenom']
                    ]);
                }
                else{
                    insert("cours",[
                        "intitule_cours" => $intitule,
                        "id_matiere_fk_cours" => $matiere,
                        "id_classe_fk_cours" => $classe,
                        "id_professeur_fk_cours" => $professeur,
                        "date_debut_cours" => $date_debut,
                        "notes_cours" => $notes,
                        "fichier_1_cours" => $fichier1,
                        "fichier_2_cours" => $fichier2,
                        "fichier_3_cours" => $fichier3,
                        "fichier_4_cours" => $fichier4,
                        "date_create_cours" => $now->format('Y-m-d H:i:s'),
                        "user_create_cours" => $_SESSION['nom']." ".$_SESSION['prenom'],
                        "date_last_modif_cours" => $now->format('Y-m-d H:i:s'),
                        "user_last_modif_cours" => $_SESSION['nom']." ".$_SESSION['prenom']
                    ]);
                }
                setcookie("success","Le cours ". $intitule ." a été enregistré.",time()+(86400*30),"/");
                header("Location:cours.php");
            }
            
        }
        else{
            $alert_text = "Veuillez renseigner tous les chmaps.";
        }
    }
?>
<!Doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Cours | O-Class</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include("../../others/header-inclusion.php"); ?>
        <style>
            .active{
                font-size: 1.5rem;
                font-weight: bold;
                margin-left: 20px;
                color: #03a9f4;
            }
        </style>
    </head>
    <body>
        <?php
            if(isset($alert_text)){
                ?>
                <script>
                    swal("Échoué", "<?php echo $alert_text ?>", "error")
                </script>
                <?php
            }
        ?>
        <!-- Start Left menu area -->
        <?php include("../parts/sidebar.php"); ?>
        <div class="all-content-wrapper">
            <?php include("../parts/header.php") ?>
            <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="breadcome-heading">
                                            <form role="search" class="sr-input-func">
                                                <input type="text" placeholder="Search..." class="search-int form-control">
                                                <a href="#"><i class="fa fa-search"></i></a>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <ul class="breadcome-menu">
                                            <li><a href="#">Home</a> <span class="bread-slash">/</span>
                                            </li>
                                            <li><span class="bread-blod">Cours</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form Start -->
            <div class="single-pro-review-area mt-t-30 mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="product-payment-inner-st">
                                <ul id="myTabedu1" class="tab-review-design">
                                    <li class="active">Ajout de cours</li>
                                </ul>
                                <div id="myTabContent" class="tab-content custom-product-edit">
                                    <div id="reviews">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="review-content-section">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <form method="post" enctype="multipart/form-data" action="" class="devit-card-custom container-fluid">
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="intitule">Intitulé</label>
                                                                            <input type="text" name="intitule" class="form-control" id="intitule" value="<?php if(isset($_POST['intitule'])){ echo($_POST['intitule']); } ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="matiere">Matière</label>
                                                                            <select name="matiere" id="matiere" class="form-control">
                                                                                <option value="">---</option>
                                                                                <?php
                                                                                    if(isset($_POST['matiere'])){
                                                                                        echo(charger_matiere($_POST['matiere']));
                                                                                    }else{
                                                                                        echo(charger_matiere(null));
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="classe">Classe</label>
                                                                            <select name="classe" id="classe" class="form-control">
                                                                                <option value="">---</option>
                                                                                <?php
                                                                                    if(isset($_POST['classe'])){
                                                                                        echo(charger_classe($_POST['classe']));
                                                                                    }else{
                                                                                        echo(charger_classe(null));
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="date_debut">Date de début de la publication</label>
                                                                            <input type="datetime-local" name="date_debut" class="form-control" id="date_debut" value="<?php if(isset($_POST['date_debut'])){ echo($_POST['date_debut']); } ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <input type="checkbox" name="pas_de_fin" id="pas_de_fin" <?php if(isset($_POST['pas_de_fin'])){ echo "checked"; } ?>>
                                                                            <label for="pas_de_fin">Pas de fin</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group" id="date_fin_div">
                                                                            <label for="date_fin">Date de fin de la publication</label>
                                                                            <input type="datetime-local" name="date_fin" class="form-control" id="date_fin" value="<?php if(isset($_POST['date_fin'])){ echo($_POST['date_fin']); } ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="fichier1">Fichier 1</label>
                                                                            <input type="file" name="fichier1" class="form-control" id="fichier1">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="fichier2">Fichier 2</label>
                                                                            <input type="file" name="fichier2" class="form-control" id="fichier2">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="fichier3">Fichier 3</label>
                                                                            <input type="file" name="fichier3" class="form-control" id="fichier3">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="fichier4">Fichier 4</label>
                                                                            <input type="file" name="fichier4" class="form-control" id="fichier4">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="notes">Notes</label>
                                                                            <textarea rows="4" name="notes" id="notes"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="submit" name="submit" class="btn btn-primary waves-effect waves-light" value="Ajouter">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->
            <?php include("../parts/footer.php"); ?>
        </div>
        <?php include("../../others/footer-inclusion.php"); ?>
        <script>
            <?php
                if(isset($_POST['pas_de_fin'])){
                    ?>
                    $("#date_fin_div").hide();
                    <?php
                }
            ?>
            $("#pas_de_fin").click(function(){
                $("#date_fin_div").slideToggle();
            });
        </script>
    </body>
</html>