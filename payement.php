<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Payement / Gestion Ecole</title>
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
                    <li class="active">Payement</li>
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
                            <th>Niveau</th>
                            <th>Année scolaire</th>
                            <th>Reste à payer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody ng-controller="tableCtrl">
                        
                    
                        
                        <tr ng-if="info=='oui'">
                            <td colspan="15">Pas d'enregistrement</td>
                        </tr>
                        
                        <tr ng-repeat="row in donnees | filter: {nom:LeNom , niveau:niveau , annee_scolaire:annee}">
                            <td>{{row.nom}}</td>
                            <td>{{row.prenom}}</td>
                            <td>{{row.niveau}}</td>
                            <td>{{row.annee_scolaire}}</td>
                            <td>{{row.frais_formation}}</td>
                            <td class="text-center">
                                <a class="btn btn-primary btn-xs" href="select?id={{row.id}}">Sélectionner</a>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.payement').removeClass('no');
                $('.payement').addClass('select');
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