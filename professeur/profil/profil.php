<?php
    include("../control-if-user-is-connected.php");
?>
<!Doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Profil | Kiaalap</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include("../../others/header-inclusion.php"); ?>
    </head>
    <body>
        <?php
            if(isset($_POST['submit'])){
                if(!empty($_POST['id']) && !empty($_POST['email']) && !empty($_POST['tel']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])){
                    $password = htmlspecialchars($_POST['password']);
                    $password_confirm = htmlspecialchars($_POST['password_confirm']);
                    if($password == $password_confirm){
                        $statement = $bdd->prepare("SELECT * FROM professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne INNER JOIN matiere ON id_matiere_fk_professeur=id_matiere WHERE del_personne='0' AND id_professeur = ?");
                        $statement->execute(array($_POST['id']));
                        $old_value = $statement->fetch();
                        $photo = $old_value['photo_personne'];
                        // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
                        if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0)
                        {
                            // Testons si le fichier n'est pas trop gros
                            if ($_FILES['photo']['size'] <= 1000000000)
                            {
                                // Testons si l'extension est autorisée
                                $infosfichier = pathinfo($_FILES['photo']['name']);
                                $extension_upload = $infosfichier['extension'];
                                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png','JPG', 'JPEG', 'GIF', 'PNG');
                                if (in_array($extension_upload, $extensions_autorisees))
                                {
                                    // On peut valider le fichier et le stocker définitivement
                                    $photo = htmlspecialchars(basename($_FILES['photo']['name']));
                                    move_uploaded_file($_FILES['photo']['tmp_name'], "../../img/personnes/".$photo);
                                    
                                }
                                else{
                                    ?>
                                    <script>swal("Échoué", "Extension de la photo de profil n'est acceptable.", "error")</script>
                                    <?php
                                }
                            }
                            else{
                                ?>
                                <script>swal("Échoué", "La photo de profil est trop volumineux.", "error")</script>
                                <?php
                            }            
                        }
                        $id = htmlspecialchars($_POST['id']);
                        $email = htmlspecialchars($_POST['email']);
                        $tel = htmlspecialchars($_POST['tel']);
                        $now = new DateTime();
                        update(" professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne INNER JOIN matiere ON id_matiere_fk_professeur=id_matiere INNER JOIN compte ON id_personne=id_personne_fk_compte ",[
                            "email_personne" => $email,
                            "tel_personne" => $tel,
                            "photo_personne" => $photo,
                            "date_last_modif_personne" => $now->format('Y-m-d H:i:s'),
                            "user_last_modif_personne" => $_SESSION['nom']." ".$_SESSION['prenom'],
                            "mdp_compte" => $password
                        ], " id_professeur=".$id);
                        $_SESSION["email"] = $email;
                        $_SESSION["tel"] = $tel;
                        $_SESSION["photo"] = $photo;
                        ?>
                        <script>
                            swal("Effectué", "Mise à jour effectué.", "success")
                        </script>
                        <?php
                    }
                    else{
                        ?>
                        <script>swal("Échoué", "Mots de passe non identites.", "error")</script>
                        <?php
                    }
                }
                else{
                    ?>
                    <script>swal("Échoué", "Veuillez renseigner tous les chmaps.", "error")</script>
                    <?php
                }
            }

            if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
                $statement = $bdd->prepare("SELECT * FROM professeur INNER JOIN personne ON id_personne_fk_professeur=id_personne INNER JOIN compte ON id_personne=id_personne_fk_compte INNER JOIN matiere ON id_matiere_fk_professeur=id_matiere WHERE del_personne='0' AND id_personne = ?");
                $statement->execute(array($_SESSION['id']));
                $old_value = $statement->fetch();
                $_POST['id'] = $old_value['id_professeur'];
                $_POST['nom'] = $old_value['nom_personne'];
                $_POST['prenom'] = $old_value['prenom_personne'];
                $_POST['email'] = $old_value['email_personne'];
                $_POST['sexe'] = $old_value['sexe_personne'];
                $_POST['tel'] = $old_value['tel_personne'];
                $_POST['matiere'] = $old_value['id_matiere'];
                $_POST['notes'] = $old_value['notes_professeur'];
                $_POST['password'] = $old_value['mdp_compte'];
                $_POST['password_confirm'] = $old_value['mdp_compte'];
                
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
                                            <li><span class="bread-blod">Profil</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-pro-review-area mt-t-30 mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="profile-info-inner">
                                <div class="profile-img">
                                    <img  src='../../img/personnes/<?php echo $_SESSION['photo']; ?>'>
                                </div>
                                <div class="profile-details-hr">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                            <div class="address-hr">
                                                <p><b>Nom</b><br /> <?php echo $_SESSION['nom']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                            <div class="address-hr tb-sm-res-d-n dps-tb-ntn">
                                                <p><b>Prénom</b><br /> <?php echo $_SESSION['prenom']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="address-hr">
                                                <p><b>Email</b><br /> <?php echo $_SESSION['email']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="address-hr tb-sm-res-d-n dps-tb-ntn">
                                                <p><b>Téléphone</b><br /> <?php echo $_SESSION['tel']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="address-hr">
                                                <a href="#"><i class="fa fa-facebook"></i></a>
                                                <h3>500</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="address-hr">
                                                <a href="#"><i class="fa fa-twitter"></i></a>
                                                <h3>900</h3>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div class="address-hr">
                                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                                <h3>600</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                            <div class="product-payment-inner-st res-mg-t-30 analysis-progrebar-ctn">
                                <ul id="myTabedu1" class="tab-review-design">
                                    <li class="active"><a href="#INFORMATION">Modifier les détails</a></li>
                                </ul>
                                <div id="myTabContent" class="tab-content custom-product-edit st-prf-pro">
                                    <div class="product-tab-list tab-pane fade active in" id="INFORMATION">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="review-content-section">
                                                    <form method="post" enctype="multipart/form-data" action="" class="devit-card-custom container-fluid">
                                                        <input type="text" hidden name="id" value="<?php if(isset($_POST['id'])){ echo($_POST['id']); } ?>">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="nom">Nom</label>
                                                                    <input readonly type="text" name="nom" class="form-control" id="nom" value="<?php if(isset($_POST['nom'])){ echo($_POST['nom']); } ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="prenom">Prénom</label>
                                                                    <input readonly type="text" name="prenom" class="form-control" id="prenom" value="<?php if(isset($_POST['prenom'])){ echo($_POST['prenom']); } ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="sexe">Sexe</label>
                                                                    <select disabled name="sexe" id="sexe" class="form-control">
                                                                        <option value="">---</option>
                                                                        <option value="M" <?php if(isset($_POST['sexe']) && $_POST['sexe']=='M'){ echo('selected'); } ?>>Masculin</option>
                                                                        <option value="F" <?php if(isset($_POST['sexe']) && $_POST['sexe']=='F'){ echo('selected'); } ?>>Féminin</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="matiere">Matière</label>
                                                                    <select disabled name="matiere" id="matiere" class="form-control">
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
                                                                    <label for="tel">Téléphone</label>
                                                                    <input type="text" name="tel" class="form-control" id="tel" value="<?php if(isset($_POST['tel'])){ echo($_POST['tel']); } ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="email">Email</label>
                                                                    <input type="email" name="email" class="form-control" id="email" value="<?php if(isset($_POST['email'])){ echo($_POST['email']); } ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="password">Mot de passe</label>
                                                                    <input type="password" name="password" class="form-control" id="password" value="<?php if(isset($_POST['password'])){ echo($_POST['password']); } ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label for="password_confirm">Ressaisir le mot de passe</label>
                                                                    <input type="password" name="password_confirm" class="form-control" id="password_confirm" value="<?php if(isset($_POST['password_confirm'])){ echo($_POST['password_confirm']); } ?>">
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
                                                        </div>
                                                        <input type="submit" name="submit" class="btn btn-primary waves-effect waves-light" value="Modifier">
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
            <?php include("../parts/footer.php"); ?>
        </div>
        <?php include("../../others/footer-inclusion.php"); ?>
    </body>
</html>