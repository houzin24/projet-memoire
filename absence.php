<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Absence / Gestion Ecole</title>
        
        <?php include("head.php"); ?>
    </head>
    
    <body>
        
        <!--sidebar-->
        <?php include('sidebar.php'); ?>
        <!--Fin sidebar-->
        
        <div class="container conteneur">
            <?php include('en_tete.php'); ?>
            
            <nav class="navbar navbar-default">
                <ul class="breadcrumb">
                    <li class="active">Absence</li>
                    <li><a href="ajout_absence">Ajouter une absence</a></li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Niveau</th>
                            <th>Jour</th>
                            <th>Heure</th>
                            <th>Matière</th>
                            <th>Enregistré par</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    $req=$bdd->query('SELECT * FROM absence ORDER BY id DESC');
                    if(FALSE == ($reponse = $req->fetch())){
                    ?>
                    <td colspan="10">Pas d'enregistrement</td>
                    <?php
                    } else{
                        do{
                            $demande = $bdd->prepare('SELECT nom, prenom, niveau FROM etudiants WHERE id = ?');
                            $demande->execute(array($reponse['id_etudiant']));
                            $reponse1 = $demande->fetch();
                            
                            $demande3 = $bdd->prepare('SELECT * FROM niveau WHERE id = ?');
                            $demande3->execute(array($reponse1['niveau']));
                            $reponse3 = $demande3->fetch();
                            
                            $demande2 = $bdd->prepare('SELECT id, heure FROM heure WHERE id = ?');
                            $demande2->execute(array($reponse['id_heure']));
                            $reponse2 = $demande2->fetch();
                            
                            $demande4 = $bdd->prepare('SELECT id_matiere FROM seance WHERE id_niveau = ? AND jour = ? AND id_heure = ?');
                            $demande4->execute(array(
                                $reponse3['id'],
                                $reponse['jour'],
                                $reponse2['id']));
                            $reponse4 = $demande4->fetch();
                            
                            if($reponse4){
                                $demande5 = $bdd->prepare('SELECT matiere FROM matiere WHERE id = ?');
                                $demande5->execute(array($reponse4['id_matiere']));
                                $reponse5 = $demande5->fetch();
                            } else{
                                $reponse5['matiere'] = "";
                            }
                    ?>
                    <tr>
                        <td><?php echo $reponse1['nom']; ?></td>
                        <td><?php echo $reponse1['prenom']; ?></td>
                        <td><?php echo $reponse3['niveau'].' '.$reponse3['filiere'].' '.$reponse3['annee']; ?></td>
                        <td><?php echo $reponse['jour']; ?></td>
                        <td><?php echo $reponse2['heure']; ?></td>
                        <td><?php echo $reponse5['matiere']; ?></td>
                        <td><?php echo $reponse['user']; ?></td>
                        <td><?php echo $reponse['date']; ?></td>
                    </tr>
                    <?php
                        }while($reponse = $req->fetch());
                    }
                    ?>
                        
                    </tbody>
                </table>
        </div>
        
        <?php include("footer.php"); ?>
        <script>
            $(document).ready(function(){
                $('.absence').removeClass('no');
                $('.absence').addClass('select');
            });
        </script>
    </body>
</html>