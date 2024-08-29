<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>

<?php
if(isset($_GET['supp'])){
    $requete = $bdd->prepare('DELETE FROM etudiants WHERE id = ?');
    $requete->execute(array($_GET['supp']));
    
    $requete = $bdd->prepare('DELETE FROM parent WHERE id_etudiant = ?');
    $requete->execute(array($_GET['supp']));
    
    $requete = $bdd->prepare('DELETE FROM absence WHERE id_etudiant = ?');
    $requete->execute(array($_GET['supp']));
    
    $requete = $bdd->prepare('DELETE FROM participant WHERE id_etudiant = ?');
    $requete->execute(array($_GET['supp']));
    
    header('location: etudiant.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Etudiants / Gestion Ecole</title>
        <?php include("head.php"); ?>
    </head>
    
    <body ng-app="MonApp">
        
        <!--sidebar-->
        <?php include('sidebar.php'); ?>
        <!--Fin sidebar-->
        
        <div class="container conteneur">
            <?php include('en_tete.php'); ?>
            
            <nav class="navbar navbar-default">
                <ul class="breadcrumb">
                    <li class="active">Etudiants</li>
                    
                    <?php
                    if($_SESSION['GEtype'] == 'Admin'){
                    ?>
                    <li><a href="ajout_etudiant">Ajouter étudiant</a></li>
                    <?php
                    }
                    ?>
                    
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Filtrer par nom
                            </div>
                            <input class="form-control" ng-model="LeNom" placeholder="Chercher un étudiant">
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Filtrer par niveau
                            </div>
                            <select class="form-control" ng-model="niveau">
                                <option value="">Par défaut</option>
                                <?php
                                $requete = $bdd->query('SELECT * FROM niveau');
                                while($donnees = $requete->fetch()){
                                ?>
                                <option><?php echo $donnees['niveau'].' '.$donnees['filiere'].' '.$donnees['annee'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                Filtrer par Annee scolaire
                            </div>
                            <select class="form-control" ng-model="annee">
                                <option value="">Par défaut</option>
                                <?php
                                $requete = $bdd->query('SELECT * FROM annees');
                                while($donnees = $requete->fetch()){
                                ?>
                                <option><?php echo $donnees['debut'].' - '.$donnees['fin'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col table-responsive">
            <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Sexe</th>
                            <th>Naissance</th>
                            <th>Nationnalité</th>
                            
                            <?php
                            if($_SESSION['GEtype'] == 'Admin'){
                            ?>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <?php
                            }
                            ?>
                            
                            <th>Niveau</th>
                            
                            <?php
                            if($_SESSION['GEtype'] == 'Admin'){
                            ?>
                            <th>Parent</th>
                            <?php
                            }
                            ?>
                            
                            <th>Année scolaire</th>
                            
                            <?php
                            if($_SESSION['GEtype'] == 'Admin'){
                            ?>
                            <th>Frais formation</th>
                            <th>Action</th>
                            <?php
                            }
                            ?>
                            
                        </tr>
                    </thead>
                    <tbody ng-controller="tableCtrl">
                        
                        <tr ng-if="info=='oui'">
                            <td colspan="15">Pas d'enregistrement</td>
                        </tr>
                        
                        <tr ng-repeat="row in donnees | filter: {nom:LeNom , niveau:niveau , annee_scolaire:annee}">
                            <td>{{row.nom}}</td>
                            <td>{{row.prenom}}</td>
                            <td>{{row.sexe}}</td>
                            <td>{{row.naissance}}</td>
                            <td>{{row.nationalite}}</td>
                            
                            <?php
                            if($_SESSION['GEtype'] == 'Admin'){
                            ?>
                            <td>{{row.tel}}</td>
                            <td>{{row.adresse}}</td>
                            <?php
                            }
                            ?>
                            
                            <td>{{row.niveau}}</td>
                            
                            <?php
                            if($_SESSION['GEtype'] == 'Admin'){
                            ?>
                            <td>{{row.parent}}</td>
                            <?php
                            }
                            ?>
                            
                            <td>{{row.annee_scolaire}}</td>
                            
                            <?php
                            if($_SESSION['GEtype'] == 'Admin'){
                            ?>
                            <td>{{row.frais_formation}}</td>
                            <td class="text-center">
                                <a class="btn btn-danger btn-sm" href="?supp={{row.id}}">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                            <?php
                            }
                            ?>
                            
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.etudiant').removeClass('no');
                $('.etudiant').addClass('select');
            });
            
        
            
            var app = angular.module('MonApp', []);
            app.controller('tableCtrl', function($scope, $http){ //1
                
                $http.get("angular.php").then(function (response){ //2
                    $scope.donnees = response.data;
                    
                    if($scope.donnees.length==0){
                        $scope.info = "oui";
                    }
                }); //Fin 2        
                
            }); //Fin 1
        </script>
    </body>
</html>