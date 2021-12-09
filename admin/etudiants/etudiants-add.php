<?php
    include("../control-if-user-is-connected.php");
    if(isset($_POST['submit'])){
        if(!empty($_POST['matricule']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['sexe']) && !empty($_POST['classe']) && !empty($_POST['tel']) && !empty($_POST['date']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])){
            $password = htmlspecialchars($_POST['password']);
            $password_confirm = htmlspecialchars($_POST['password_confirm']);
            if($password == $password_confirm){
                $email = htmlspecialchars($_POST['email']);
                $statement = $bdd->prepare("SELECT * FROM personne WHERE del_personne='0' AND email_personne = ?");
                $statement->execute(array($email));
                if($statement->rowCount() < 1){
                    $photo = "default.jpg";
                    // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
                    if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0)
                    {
                        // Testons si le fichier n'est pas trop gros
                        if ($_FILES['photo']['size'] <= 1000000000)
                        {
                            // Testons si l'extension est autorisée
                            $infosfichier = pathinfo($_FILES['photo']['name']);
                            $extension_upload = $infosfichier['extension'];
                            $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                            if (in_array($extension_upload, $extensions_autorisees))
                            {
                                // On peut valider le fichier et le stocker définitivement
                                $photo = htmlspecialchars(basename($_FILES['photo']['name']));
                                move_uploaded_file($_FILES['photo']['tmp_name'], "../../img/personnes/".$photo);
                                
                            }
                            else{
                                $alert_text = "Extension de la photo de profil n'est acceptable.";
                            }
                        }
                        else{
                            $alert_text = "La photo de profil est trop volumineux.";
                        }            
                    }
                    $matricule = htmlspecialchars($_POST['matricule']);
                    $nom = htmlspecialchars($_POST['nom']);
                    $prenom = htmlspecialchars($_POST['prenom']);
                    $sexe = htmlspecialchars($_POST['sexe']);
                    $classe = htmlspecialchars($_POST['classe']);
                    $tel = htmlspecialchars($_POST['tel']);
                    $date = htmlspecialchars($_POST['date']);
                    $notes = htmlspecialchars($_POST['notes']);
                    $now = new DateTime();
                    insert("personne",[
                        "nom_personne" => $nom,
                        "prenom_personne" => $prenom,
                        "email_personne" => $email,
                        "tel_personne" => $tel,
                        "sexe_personne" => $sexe,
                        "date_naissance_personne" => $date,
                        "photo_personne" => $photo,
                        "date_create_personne" => $now->format('Y-m-d H:i:s'),
                        "user_create_personne" => $_SESSION['nom']." ".$_SESSION['prenom'],
                        "date_last_modif_personne" => $now->format('Y-m-d H:i:s'),
                        "user_last_modif_personne" => $_SESSION['nom']." ".$_SESSION['prenom']
                    ]);
                    $statement = $bdd->query("SELECT MAX(id_personne) as last_id_personne FROM personne");
                    $row = $statement->fetch();
                    insert("etudiant",[
                        "matricule_etudiant" => $matricule,
                        "notes_etudiant" => $notes,
                        "id_personne_fk_etudiant" => $row['last_id_personne'],
                        "id_classe_fk_etudiant" => $classe
                    ]);
                    insert("compte",[
                        "mdp_compte" => $password,
                        "date_create_compte" => $now->format('Y-m-d H:i:s'),
                        "user_create_compte" => $_SESSION['nom']." ".$_SESSION['prenom'],
                        "date_last_modif_compte" => $now->format('Y-m-d H:i:s'),
                        "user_last_modif_compte" => $_SESSION['nom']." ".$_SESSION['prenom'],
                        "id_personne_fk_compte" => $row['last_id_personne'],
                        "id_type_compte_fk_compte" => 3
                    ]);
                    
                    setcookie("success","L'étudiant ". $nom ." ". $prenom ." a été enregistré.",time()+(86400*30),"/");
                    header("Location:etudiants.php");
                }
                else{
                    $alert_text = "Cet email existe déjà.";
                }
            }
            else{
                $alert_text = "Mots de passe non identites.";
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
        <title>Étudiants | Kiaalap</title>
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
                                            <li><span class="bread-blod">Étudiants</span>
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
                                    <li class="active">Ajout d'étudiant</li>
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
                                                                            <label for="matricule">Matricule</label>
                                                                            <input type="text" name="matricule" class="form-control" id="matricule" value="<?php if(isset($_POST['matricule'])){ echo($_POST['matricule']); } ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="nom">Nom</label>
                                                                            <input type="text" name="nom" class="form-control" id="nom" value="<?php if(isset($_POST['nom'])){ echo($_POST['nom']); } ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="prenom">Prénom</label>
                                                                            <input type="text" name="prenom" class="form-control" id="prenom" value="<?php if(isset($_POST['prenom'])){ echo($_POST['prenom']); } ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="sexe">Sexe</label>
                                                                            <select name="sexe" id="sexe" class="form-control">
                                                                                <option value="">---</option>
                                                                                <option value="M" <?php if(isset($_POST['sexe']) && $_POST['sexe']=='M'){ echo('selected'); } ?>>Masculin</option>
                                                                                <option value="F" <?php if(isset($_POST['sexe']) && $_POST['sexe']=='F'){ echo('selected'); } ?>>Féminin</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="date">Date de naissance</label>
                                                                            <input type="date" name="date" class="form-control" id="date" value="<?php if(isset($_POST['date'])){ echo($_POST['date']); } ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="tel">Téléphone</label>
                                                                            <input type="text" name="tel" class="form-control" id="tel" value="<?php if(isset($_POST['tel'])){ echo($_POST['tel']); } ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="email">Email</label>
                                                                            <input type="email" name="email" class="form-control" id="email" value="<?php if(isset($_POST['email'])){ echo($_POST['email']); } ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="password">Mot de passe</label>
                                                                            <input type="password" name="password" class="form-control" id="password" value="<?php if(isset($_POST['password'])){ echo($_POST['password']); } ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="password_confirm">Ressaisir le mot de passe</label>
                                                                            <input type="password" name="password_confirm" class="form-control" id="password_confirm" value="<?php if(isset($_POST['password_confirm'])){ echo($_POST['password_confirm']); } ?>">
                                                                        </div>
                                                                    </div>
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
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12 col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="photo">Photo de profil</label>
                                                                            <input type="file" name="photo" class="form-control" id="photo">
                                                                        </div>
                                                                    </div>
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
    </body>
</html>