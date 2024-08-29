<?php
include("session.php");
include("redirection.php");
include("connexionBDD.php");
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Parent / Gestion Ecole</title>
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
                    <li class="active">Parent</li>
                </ul>
                
                <?php include('navbar.php'); ?>
            </nav>
            
            <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Parent</th>
                            <th>Etudiant</th>
                            <th>Téléphone</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php
                    $req=$bdd->query('SELECT * FROM parent ORDER BY id DESC');
                    if(FALSE == ($reponse = $req->fetch())){
                    ?>
                    <td colspan="10">Pas d'enregistrement</td>
                    <?php
                    } else{
                        do{
                            $requete = $bdd->prepare('SELECT nom, prenom FROM etudiants WHERE id = ?');
                            $requete->execute(array($reponse['id_etudiant']));
                            $donnee = $requete->fetch();
                    ?>
                    <tr>
                        <td><?php echo $reponse['nom']; ?></td>
                        <td><?php echo $reponse['prenom']; ?></td>
                        <td><?php echo $reponse['type']; ?></td>
                        <td><?php echo $donnee['nom'].' '.$donnee['prenom']; ?></td>
                        <td><?php echo $reponse['tel']; ?></td>
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
                $('.parent').removeClass('no');
                $('.parent').addClass('select');
            });
        </script>
    </body>
</html>