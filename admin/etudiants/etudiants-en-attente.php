<?php
    include("../control-if-user-is-connected.php");
?>
<!Doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>√Čtudiants | Kiaalap</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include("../../others/header-inclusion.php"); ?>
    </head>
    <body>
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
                                            <li><span class="bread-blod">√Čtudiants</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Static Table Start -->
            <div class="data-table-area mg-b-15">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="sparkline13-list">
                                <div class="sparkline13-hd">
                                    <div class="main-sparkline13-hd" style="display: flex; justify-content: space-between;margin-bottom: 40px;">
                                        <h1>Tous les √©tudiants en attente</h1>
                                    </div>
                                </div>
                                <div class="sparkline13-graph">
                                    <div class="datatable-dashv1-list custom-datatable-overright">
                                        <table id="table" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Photo</th>
                                                    <th>Matricule</th>
                                                    <th>Nom</th>
                                                    <th>Pr√©nom</th>
                                                    <th>Sexe</th>
                                                    <th>Classe</th>
                                                    <th>Tel</th>
                                                    <th>Email</th>
                                                    <th>Statut</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Static Table End -->
            <?php include("../parts/footer.php"); ?>
        </div>
        <?php include("../../others/footer-inclusion.php"); ?>


        <div id="modal_view" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="form_view">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title_view"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">√ó</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div id="details"></div>
                        </div>

                    </div>
                </form>
            </div>
        </div>


        <script>
            /* Affichage de la liste */ //changer
            console.log($('#table'));
            var etudiantsDataTable = $('#table').DataTable({
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"etudiants-fetch-en-attente.php", //changer
                    type:"POST"
                },
                "columnDefs":[
                    {
                        "targets":[], // changer l'index des colonnes qui ne seront pas tri√©es
                        "orderable":false,
                    },
                ],
                "bSort" : false,
                "pageLength": 10
            });


            $(document).on('click', '.activation', function(){
                var id = $(this).attr('id');
                swal({
                    title: 'Validation d\'√©tudiant',
                    text: 'Etes-vous s√Ľre de vouloir valider cet √©tudiant ?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: false,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var id = $(this).attr("id");
                        var btn_action = "activation";
                        $.ajax({
                            url:"etudiants-action.php",
                            method:"POST",
                            data:{id:id,btn_action:btn_action},
                            dataType:"json",
                            success:function(data)
                            {
                                if(data){
                                    swal("Effectu√©", "L'inscription de l'√©tudiant a √©t√© valid√©e.", "success");
                                }
                                else{
                                    swal('√Čchou√©','La validation a √©chou√©e.', 'error');
                                }
                                etudiantsDataTable.ajax.reload();
                            }
                        })
                    }
                });

            });


            $(document).on('click', '.delete', function(){
                var id = $(this).attr('id');
                swal({
                    title: 'Reject d\'√©tudiant',
                    text: 'Etes-vous s√Ľre de vouloir rejeter cet √©tudiant ?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: false,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var id = $(this).attr("id");
                        var btn_action = "delete";
                        $.ajax({
                            url:"etudiants-action.php",
                            method:"POST",
                            data:{id:id,btn_action:btn_action},
                            dataType:"json",
                            success:function(data)
                            {
                                if(data){
                                    swal("Effectu√©", "L'√©tudiant a √©t√© rejet√©.", "success");
                                }
                                else{
                                    swal('√Čchou√©','Le reject a √©chou√©.', 'error');
                                }
                                etudiantsDataTable.ajax.reload();
                            }
                        })
                    }
                });

            });
        </script>
    </body>
</html>